@extends('layouts.app')

@section('content')

    <div class="item">
        <div class="img-bg">
            <img src="<?=('image/home-background.jpg')?>" alt=".">
        </div>
        <div class="row mt-12">
            <div class="col-md-12">
                <div class="home-section-column home-banner">
                    <h1 style=" text-align: center; color:#fff">GET PAID FOR CONNECTING<br>WITH YOUR FANS</h1>
                    <a href="{{url('/register')}}" class="btn btn-danger"><h4>Create Your Account</h4></a>
                </div>
            </div>
        </div>
    </div>

    <div class="item">
        <div class="p-2 p-sm-5   bg-white home-section-column">
            <h2>What is Razeline</h2>

            <div class="intro container text-sm-left text-center my-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-5 mb-sm-3 mb-md-0">
                        <h4 class="vertical-center">RazeLine allows you to get paid to take prescreened messages from
                            your fans as either an one
                            time payment or a super fan per month recurring payment </h4>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-5 mb-sm-3 mb-md-0">
                        <img src="<?=asset('image/about.jpg')?>" class="img-responsive m-auto img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="p-2 p-sm-5 home-section-column">

            <h2>How it works</h2>
            <div class="helps container">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="<?=asset('image/like.png')?>">
                        <h4>Share your RazeLine profile link on your social media pages so your fans can
                            support you.</h4>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="<?=asset('image/message.png')?>">
                        <h4>Receive prescreened 140 character private messages from your fans and personally reply
                            within 7 days for a one time payment or add on exclusive
                            content for a monthly recurring payment.</h4>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="<?=asset('image/payment.png')?>">
                        <h4>Get Paid.</h4>
                    </div>
                </div>

            </div>
            <div class="fee text-center">
                <h4>RazeLine takes out 25% for each message<br>response and an industry low 5%
                    for monthly<br>subscriptions.</h4>
            </div>
        </div>
    </div>

@endsection
