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
                        <h3 class="my-5" style=" text-align: center; color:#fff">CONNECT DIRECTLY WITH INFLUENCERS AND
                            CREATORS</h3>
                        <div class="my-3">
                            <form class="input-group m-2 my-lg-0" method="get" action="{{url('/find')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="text" name="keyword" id="text-keyword" placeholder="Enter creator name">
                                <button class="submit" id="btn-search"><i class="fa fa-search"></i>&nbsp;Search</button>
                            </form>
                        </div>
                        <h3 class="my-5" style=" text-align: center; color:#fff">All creators are verified to be
                            themselves<br> and guarantee a response</h3>
                        <div class="my-5">
                            <button class="btn btn-danger" onclick="goto_creator_tab()"
                                    style="position: relative; top:-30px; padding: 8px 40px;"><h5>Explore</h5></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="item">
        <div class="py-5 bg-white">
            <div class="home-section-column">
                <h2 class="pb-3">What is Razeline?</h2>

                <p class="intro2">We at RazeLine have created a platform that allows fans and anyone else to connect
                    directly with creators and directly interact with them <strong><font color="#2e3192">One on
                            One</font></strong> while providing a safe method for creators to receive and respond to
                    private messages.</p>
                <p class="intro2">All messages are personally responded to by the creator within 72 hours <br>or your
                    money
                    back.</p>
            </div>
        </div>

        <div class="py-5">
            <div class="home-section-column">

                <h2 class="pb-3">How it works</h2>

                <div class="helps container">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <img src="<?=asset('image/redirect.png')?>">
                            <h4 class="how"><strong style="color:#2e3192">1.</strong> Sign Up</h4>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <img src="<?=asset('image/group.png')?>">
                            <h4 class="how"><strong style="color:#2e3192">2.</strong> Choose a creator</h4>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <img src="<?=asset('image/message.png')?>">
                            <h4 class="how"><strong style="color:#2e3192">3.</strong> Type a message of up to 180
                                characters, sign into Paypal then send your message.</h4>
                        </div>
                    </div>
                </div>
                <p class="my-5"><strong>You need a valid credit card attached to your PayPal account in order send a message.</strong></p>
            </div>
        </div>

        <div class="py-5 white" id="found_creator_list">
            <div class="home-section-column container">
                <h2>FIND A CREATOR</h2>

                <div class="section-creators p-1 p-sm-3">
                    @foreach($creators as $c)
                        <div class="section-creator my-5">
                            <div class="section-creator-header">
                                <img src="{{$c->photo}}" class="circle w-80 md-w-240 save-aspect">
                                <h5 class="creator_name">
                                    @if($c->slug_name)
                                        <a href="{{url('/profile')}}/{{$c->slug_name}}"
                                           class="text-primary">{{$c->name}}</a>
                                    @else
                                        <a href="{{url('/profile').'?user='.base64_encode($c->id)}}"
                                           class="text-primary">{{$c->name}}</a>
                                    @endif
                                </h5>
                            </div>
                            <div class="section-creator-body text-center text-md-left">
                                <p class="creator_description"><?php echo str_limit($c->profession, 60); ?></p>
                                <p class="creator_rate"><span> Rate: ${{$c->rate}}</span></p>

                            </div>
                            <a class="md-btn md-raised mb-2 w-xs message_btn"
                               href="{{url('/messages')}}?user={{$c->id}}"><i
                                        class="fa fa-comment-o"></i>&nbsp;&nbsp;Message</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function goto_creator_tab() {
            $('html, body').animate({
                scrollTop: $("#found_creator_list").offset().top
            }, 2000);
        }
    </script>
@endsection