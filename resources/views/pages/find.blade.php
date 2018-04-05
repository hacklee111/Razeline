@extends('layouts.app')

@section('content')

    <div class="item">
        <div class="img-bg">
            <img src="<?=('image/home-background.jpg')?>" alt=".">
        </div>
        <div class="p-0">
            <div class="row mt-12">
                <div class="col-sm-12">
                    <div class="home-section-column">
                        <h3 class="about" style=" text-align: center; color:#fff">The #1 place to connect with your favorite<br>creators directly and get VIP access.</h3>
                        <div class="about">
                            <form class="input-group m-2 my-lg-0" method="get" action="{{url('/find')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="text" name="keyword" id="text-keyword" placeholder="Enter creator name">
                                <button class="submit" id="btn-search"><i class="fa fa-search"></i>&nbsp;Search</button>
                            </form>
                        </div>
                        <h3 class="about" style=" text-align: center; color:#fff">All creators are verified to be themselves<br>
                            and guarantee a response</h3>
                        <div class="about">
                            <a href="{{url('/find')}}" class="btn btn-danger" style="position: relative; top:-30px; padding: 8px 40px;"><h5>Explore</h5></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="item">
        <div class="p-0"  style="background-color: #ffffff;">
            <div class="home-section-column">
                <h2>What is Razeline?</h2>

                <p class="intro2">We at RazeLine have created a platform that allows fans to not only support their favorite creators but to directly interact with
                    them <strong><font color="#2e3192">One on One</font></strong> while providing a safe method for
                    creators to receive and respond to private messages and provide exclusive access.</p>
                <p class="intro2">You can send and receive private messages directly from your favorite creators and can also sign up for monthly VIP access to receive exclusive content. </p>
                <p class="intro2">All messages are personally responded to by the creator within 7 days or your money back and all exclusive content and access is guaranteed.</p>
            </div>
        </div>

        <div class="p-4">
            <div class="home-section-column">
                <h2>How it works</h2>
                <div class="helps">
                    <div>
                        <img src="<?=asset('image/redirect.png')?>">
                        <h4 class="how"><strong style="color:#2e3192">1.</strong> Please sign up using<br> your <strong style="color:#d34836">Google</strong> account.</h4>
                    </div>
                    <div>
                        <img src="<?=asset('image/group.png')?>">
                        <h4 class="how"><strong style="color:#2e3192">2.</strong> Choose your creator</h4>
                    </div>
                    <div>
                        <img src="<?=asset('image/message.png')?>">
                        <h4 class="how"><strong style="color:#2e3192">3.</strong> Start messaging and/or<br>enrolling into monthly<br>VIP plans offered by<br>your creator to get<br>exclusive content.</h4>
                    </div>

                </div>
            </div>
        </div>

        <div class="p-4 white">
            <div class="home-section-column">
                <h2>Find a creator</h2>

                <div class="section-creators">
                    @foreach($creators as $c)
                        <div class="section-creator">
                            <div class="section-creators-header">

                                <img src="{{$c->photo}}" class="circle w-56 save-aspect">
                                <p><a href="{{url('/profile')}}/{{$c->slug_name}}">{{$c->name}}</a></p>
                            </div>
                            <p>
                                {{$c->description}}
                            </p>
                            <a class="md-btn md-raised mb-2 w-xs" href="{{url('/messages')}}?user={{$c->id}}"><i class="fa fa-comment-o"></i>&nbsp;&nbsp;Message</a>
                        </div>
                    @endforeach
                </div>
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
