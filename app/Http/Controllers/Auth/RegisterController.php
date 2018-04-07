<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('gmail', function ($attribute, $value, $parameters) {
            // Banned words
            if (ends_with($value, '@gmail.com')) {
                return true;
            } else {
                return false;
            }
        });

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (array_key_exists('password', $data)) {
            $password = bcrypt($data['password']);
        } else {
            $password = bcrypt('########');
        }

        $create_data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password,
            'type' => $data['type'],
        ];


        if (array_key_exists('birthday', $data))
            $create_data['birthday'] = $data['birthday'];

        if (array_key_exists('gender', $data))
            $create_data['gender'] = $data['gender'];

        if (array_key_exists('profession', $data))
            $create_data['profession'] = $data['profession'];

        if (array_key_exists('description', $data))
            $create_data['description'] = $data['description'];

        if (array_key_exists('do_not_send', $data))
            $create_data['do_not_send'] = $data['do_not_send'];

        if (array_key_exists('rate', $data))
            $create_data['rate'] = $data['rate'];

        $create_data['slug_name'] = User::getSlugName($data['name']);

        $user = User::create($create_data);

        if (Input::file('photo') && Input::file('photo')->isValid()) {
            $file_name = 'photo_' . $user->id . '_' . str_random(8) . '.' .
                Input::file('photo')->getClientOriginalExtension();

            Input::file('photo')->move(
                base_path() . '/public/attachments/', $file_name
            );

            $url = './attachments/' . $file_name;

            $user->photo = $url;
        }

        if (Input::file('background')) {
            $bg_file_name = 'background_' . $user->id . '_' . str_random(8) . '.' .
                Input::file('background')->getClientOriginalExtension();

            Input::file('background')->move(
                base_path() . '/public/attachments/', $bg_file_name
            );

            $url = './attachments/' . $bg_file_name;

            $user->background = $url;
        }

        $user->save();

        return $user;
    }
}
