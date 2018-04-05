<?php

namespace App\Http\Controllers;

use App\Mail\MessageReceived;
use App\Message;
use App\MessageChannel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PayPal\Exception\PayPalConnectionException;
use Pusher;
use Paypal;
use Redirect;

class HomeController extends Controller
{
    private $_apiContext;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['findCreators', 'index', 'profile', 'googleSign']);

        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creators = User::where('type', 'creator')->limit(9)->get();

        return view('welcome', [
            'creators' => $creators
        ]);
    }

    public function findCreators(Request $request) {
        $creators = User::where('type', 'creator')->get();

        if($request->has('keyword')) {
            $keyword = $request->input('keyword');


            $creators = User::where('type', 'creator')
                ->where(function($query) use ($keyword) {
                    $query->where('name', 'like', '%'.$keyword.'%')
                        ->orWhere('profession', 'like', '%'.$keyword.'%')
                        ->orWhere('description', 'like', '%'.$keyword.'%');
                })->get();

        }

        return view('pages.find', [
            'creators' => $creators
        ]);
    }

    public function showMessages(Request $request) {
        $me = Auth::user();
        $mi = $me->id;

        $active_channel = null;
        if($request->has('user')) {
            $user_id = $request->input('user');

            $channel = MessageChannel::where('creator_id', $user_id)
                ->where('fan_id', $mi)
                ->get()->first();

            if($channel == null) {
                $channel = new MessageChannel;
                $channel->creator_id = $user_id;
                $channel->fan_id = $mi;
                $channel->last_message = "";
                $channel->save();
            }

            $active_channel = $channel;
        } else {
            if($request->has('channel')) {
                $channel_id = $request->input('channel');
                $active_channel = MessageChannel::find($channel_id);
            }
        }

        $channels = MessageChannel::where('creator_id', $mi)
            ->orWhere('fan_id', $mi)
            ->orderBy('updated_at', 'DESC')
            ->get();

        if($active_channel == null) {
            $active_channel = $channels->first();
        }

        $messages = [];
        if($active_channel) {
            $channel_id = $active_channel->id;
            $messages = Message::where('channel_id', $channel_id)
                ->where(function($query) {
                    $query->where('status', Message::MESSAGE_STATUS_RESPONDED)
                        ->orWhere('status', Message::MESSAGE_STATUS_APPROVED);
                })
                ->get();

            foreach($messages as $m) {
                if($m->sender_id != $mi && $m->read != true) {
                    $m->read = true;
                    $m->save();
                }
            }
        }

        return view('pages.messages', [
            'channels' => $channels,
            'messages' => $messages,
            'active_channel' => $active_channel,
        ]);
    }

    //ajax call
    public function sendMessage(Request $request, $id) {
        $me = Auth::user();
        $mi = $me->id;

        $text = $request->input('message');

        $message = new Message;
        $message->channel_id = $id;
        $message->sender_id = $mi;
        $message->message = $text;
        $message->read = false;
        $message->type = 'text';

        $channel = MessageChannel::find($id);
        $creator_id = $channel->creator_id;
        $creator = User::find($creator_id);
        $fan = User::find($channel->fan_id);
        $rate = $creator->rate;

        $fan_id = $channel->fan_id;


        if($me->type == User::USER_TYPE_CREATOR || $me->subscription_available) {

            $message->status = Message::MESSAGE_STATUS_APPROVED;

            if($me->type == User::USER_TYPE_CREATOR) {

                //when creator send message, mark all fan messages in the channel as responded
                $fan_messages = Message::where('channel_id', $id)
                    ->where('sender_id', $fan_id)
                    ->get();
                foreach ($fan_messages as $m) {
                    $m->status = Message::MESSAGE_STATUS_RESPONDED;
                    $m->save();
                }
                $message->save();

                //send email notification to fan here
                Mail::to($fan)->queue(new MessageReceived($message));

            } else {
                $message->save();
            }


            $message->text = $message->message;
            $message->my_id = $mi;

            Pusher::trigger('chat'.$id,
                'new-message', $message);

        } else {

            $payer = PayPal::Payer();
            $payer->setPaymentMethod('paypal');

            $amount = PayPal:: Amount();
            $amount->setCurrency('USD');
            $amount->setTotal($rate); // This is the simple way,
            // you can alternatively describe everything in the order separately;
            // Reference the PayPal PHP REST SDK for details.

            $transaction = PayPal::Transaction();
            $transaction->setAmount($amount);
            $transaction->setDescription('Message to '.$creator->name);

            $redirectUrls = PayPal:: RedirectUrls();
            $redirectUrls->setReturnUrl(action('HomeController@paymentConfirm'));
            $redirectUrls->setCancelUrl(action('HomeController@paymentCancel'));

            $payment = PayPal::Payment();
            $payment->setIntent('sale');
            $payment->setPayer($payer);
            $payment->setRedirectUrls($redirectUrls);
            $payment->setTransactions(array($transaction));

            $response = $payment->create($this->_apiContext);

            $redirectUrl = $response->links[1]->href;
            $paymentID = $response->id;

            $message->status = Message::MESSAGE_STATUS_PENDING;
            $message->payment_id = $paymentID;
            $message->save();

            return Redirect::to( $redirectUrl );
        }
    }

    public function profile(Request $request, $slug = null) {
        $user = null;

        if($slug != null) {
            $user = User::where('slug_name', $slug)->get()->first();
        } else if($request->has('user')) {
            $user_id = $request->input('user');
            $user = User::find($user_id);
        } else if(Auth::check()) {
            $user = Auth::user();
        } else {
            return redirect()->back();
        }

        return view('pages.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request) {
        $me = Auth::user();
        if($request->has('name')) {
            $me->name = $request->input('name');
        }

        if($request->has('password') && $request->input('password') != "") {
            $password = $request->input('password');
            $confirm = $request->input('password_confirmation');
            if($password == $confirm) {
                $me->password = Hash::make($request->input('password'));
            } else {
                return response()->json([
                    'error' => 'Password does not match'
                ], 401);
            }
        }

        if($request->has('birthday')) {
            $me->birthday = $request->input('birthday');
        }

        if($request->has('gender')) {
            $me->gender = $request->input('gender');
        }

        if($request->has('education')) {
            $me->education = $request->input('education');
        }

        if($request->has('profession')) {
            $me->profession = $request->input('profession');
        }

        if($request->has('description')) {
            $me->description = $request->input('description');
        }

        if($request->has('rate')) {
            $me->rate = $request->input('rate');
        }

        if($request->has('do_not_send')) {
            $me->do_not_send = $request->input('do_not_send');
        }

        if($request->hasFile('photo')) {
            $file_name = 'photo_'.$me->id.'_'.str_random(8).'.'.
                $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->move(
                base_path() . '/public/attachments/', $file_name
            );

            $url = './attachments/' . $file_name;

            $me->photo = $url;
        }

        if($request->hasFile('background')) {
            $file_name = 'background_'.$me->id.'_'.str_random(8).'.'.
                $request->file('background')->getClientOriginalExtension();

            $request->file('background')->move(
                base_path() . '/public/attachments/', $file_name
            );

            $url = './attachments/' . $file_name;

            $me->background = $url;
        }

        $me->save();

        return view('pages.setting', [
            'user' => $me
        ]);
    }

    public function settings(Request $request) {
        $user = Auth::user();

        return view('pages.setting', [
            'user' => $user
        ]);
    }

    public function paymentConfirm(Request $request) {
        $mi = Auth::user()->id;

        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        //dd($payment);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);

            $executePayment = $payment->execute($paymentExecution, $this->_apiContext);


        // Clear the shopping cart, write to database, send notifications, etc.

        $message = Message::where('payment_id', $id)->get()->first();
        if($message == null) {
            echo "Error occurred while sending message. Please contact customer support.";
        } else {
            $message->status = Message::MESSAGE_STATUS_APPROVED;
            $message->save();

            $channel = MessageChannel::find($message->channel_id);
            $creator = User::find($channel->creator_id);

            //send email notification here
            Mail::to($creator)->queue(new MessageReceived($message));


            $message->text = $message->message;
            $message->my_id = $mi;

            Pusher::trigger('chat'.$message->channel_id,
                'new-message', $message);

            return redirect()->action(
                'HomeController@showMessages', ['channel' => $message->channel_id]
            );
        }
        // Thank the user for the purchase

    }

    public function paymentCancel(Request $request) {
        $paymentId = $request->get('paymentId');
        $message = Message::where('payment_id', $paymentId)->get()->first();

        if($message != null) {
            $message->status = Message::MESSAGE_STATUS_CANCELED;
            $message->save();

            return redirect()->action(
                'HomeController@showMessages', ['channel' => $message->channel_id]
            );
        }
    }

    public function testPayment(Request $request) {
        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal:: Amount();
        $amount->setCurrency('USD');
        $amount->setTotal(42); // This is the simple way,
        // you can alternatively describe everything in the order separately;
        // Reference the PayPal PHP REST SDK for details.

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('What are you selling?');

        $redirectUrls = PayPal:: RedirectUrls();
        $redirectUrls->setReturnUrl(action('HomeController@paymentConfirm'));
        $redirectUrls->setCancelUrl(action('HomeController@paymentCancel'));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);

        $redirectUrl = $response->links[1]->href;
        $paymentID = $response->id;

        /*
         * Payment {#239 ▼
  -_propMap: array:8 [▼
    "intent" => "sale"
    "payer" => Payer {#241 ▼
      -_propMap: array:1 [▼
        "payment_method" => "paypal"
      ]
    }
    "redirect_urls" => RedirectUrls {#237 ▼
      -_propMap: array:2 [▼
        "return_url" => "http://localhost:8000/payment/confirm"
        "cancel_url" => "http://localhost:8000/payment/cancel"
      ]
    }
    "transactions" => array:1 [▶]
    "id" => "PAY-10R75638G0443684YLKFR4IY"
    "state" => "created"
    "create_time" => "2018-02-19T18:57:39Z"
    "links" => array:3 [▼
      0 => Links {#246 ▼
        -_propMap: array:3 [▼
          "href" => "https://api.sandbox.paypal.com/v1/payments/payment/PAY-10R75638G0443684YLKFR4IY"
          "rel" => "self"
          "method" => "GET"
        ]
      }
      1 => Links {#249 ▼
        -_propMap: array:3 [▼
          "href" => "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-7L388073A01247350"
          "rel" => "approval_url"
          "method" => "REDIRECT"
        ]
      }
      2 => Links {#250 ▼
        -_propMap: array:3 [▼
          "href" => "https://api.sandbox.paypal.com/v1/payments/payment/PAY-10R75638G0443684YLKFR4IY/execute"
          "rel" => "execute"
          "method" => "POST"
        ]
      }
    ]
  ]
}
         */

        return Redirect::to( $redirectUrl );
    }

    public function confirmSubscription() {
        $me = Auth::user();

        $me->subscription_end_at = Carbon::now()->addMonth(1);
        $me->save();

        return redirect()->action('HomeController@settings');
    }

    public function cancelSubscription() {
        return redirect()->action('HomeController@settings');
    }

    public function googleSign(Request $request) {
        $email = $request->input('email');
        $name = $request->input('name');

        $user = User::where('email', $email)->get()->first();

        if($user == null) {
            //if not exist
            return view('auth.register', [
                'email'=>$email,
                'name'=>$name,
                'social'=>true,
            ]);
        } else {
            Auth::login($user);

            return redirect()->action('HomeController@index');
        }
    }
}
