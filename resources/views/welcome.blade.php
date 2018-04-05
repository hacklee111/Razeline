@extends('layouts.app')

@section('content')

    <div class="item">
        <div class="img-bg">
            <img src="<?=('image/home-background.jpg')?>" alt=".">
        </div>
        <div class="p-0">
            <div class="row mt-12">
                <div class="col-sm-12">
                    <div class="home-section-column" style="height: 500px;">
                        <h1 style=" text-align: center; color:#fff">GET PAID FOR CONNECTING<br>WITH YOUR FANS</h1>

                        <div>
                            <a href="{{url('/register')}}" class="btn btn-danger" style="position: relative; top:-30px; padding: 20px;"><h4>Create Your Account</h4></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="item">
        <div class="p-0"  style="background-color: #ffffff;">
            <div class="home-section-column">
                <h2>About</h2>
                <div class="intro">
                    <h4>RazeLine allows you to get paid<br> to take prescreened messages<br>from your fans as either an one<br>
                        time payment or a super fan per<br>month recurring payment </h4>
                    <img src="<?=asset('image/about.jpg')?>">

                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="home-section-column">
                <h2>How it works</h2>
                <div class="helps">
                    <div>
                        <img src="<?=asset('image/like.png')?>">
                        <h4>Share your RazeLine<br>profile link on your<br>social media pages so<br>your fans can support<br>you.</h4>
                    </div>
                    <div>
                        <img src="<?=asset('image/message.png')?>">
                        <h4>Receive prescreened 140<br>character private<br>messages from your fans<br>
                            and personally reply within<br>7 days for a one time<br>payment or add on<br>exclusive content for a<br>monthly recurring<br>payment.</h4>
                    </div>
                    <div>
                        <img src="<?=asset('image/payment.png')?>">
                        <h4>Get Paid.</h4>
                    </div>

                </div>
                <div class="fee"><h4>RazeLine takes out 25% for each message<br>response and an industry low 5% for monthly<br>subscriptions.</h4></div>


            </div>
        </div>

        <div class="p-0">
            <div class="back-to-top-container">
                <h5>
                    Back to top &nbsp;
                </h5>
                <a href="#"><img src="<?=asset('image/back_to_top.png')?>"></a>
            </div>
        </div>


    </div>
@endsection
