<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Razeline</title>
    <meta name="description" content="Responsive, Bootstrap, BS4"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="<?=asset('assets/images/logo.svg')?>">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="<?=asset('assets/images/logo.svg')?>">

    <!-- style -->

    <link rel="stylesheet" href="<?=asset('libs/font-awesome/css/font-awesome.min.css')?>" type="text/css"/>

    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="<?=asset('libs/bootstrap/dist/css/bootstrap.min.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?=asset('assets/css/app.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?=asset('assets/css/style.css')?>?{{time()}}" type="text/css"/>

    @yield('header')
</head>
<body>


<div class="app" id="app">
    <div id="content" class="app-content box-shadow-0" role="main">
        <!-- Header -->
        <div class="content-header white  box-shadow-0" id="content-header">
            <div class="navbar navbar-expand-lg" style="display: flex; flex-wrap:wrap; justify-content: space-between;">

                <!-- Page title -->
                <div class="navbar-text nav-title" id="pageTitle">
                    <a href="{{url('/')}}"><img src="<?=asset('image/logo.png')?>" id="nav-image"></a>
                </div>

            @auth
                <!-- Navbar collapse -->
                    <a href="#" class="mx-2 d-sm-none" data-toggle="collapse" data-target="#navbarToggler">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 512 512">
                            <path d="M64 144h384v32H64zM64 240h384v32H64zM64 336h384v32H64z"/>
                        </svg>
                    </a>
                    <div class="collapse navbar-collapse no-grow order-lg-1" id="navbarToggler">
                        <form class="input-group m-2 my-lg-0" method="get" action="{{url('/find')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <span class="input-group-btn">
		                        <button type="button" class="btn no-border no-bg no-shadow"><i class="fa fa-search"></i></button>
		                    </span>
                            <input type="text" class="form-control no-border no-bg no-shadow" name="keyword" placeholder="Search">
                        </form>


                        <div class="no-grow order-lg-1 nav-menu-item">
                            <a href="{{url('/find')}}" class="text-primary" style="margin:20px;">Find&nbsp;a&nbsp;creator</a>
                        </div>

                        <div class="no-grow order-lg-1 nav-menu-item">

                            <a href="{{url('/messages')}}" class="text-primary" style="margin:20px;">Messages<span class="badge badge-pill up danger">{{Auth::user()->unread_messages}}</span></a>

                        </div>

                        <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                            <a href="#" class="" style="margin:20px;">Messages Received: ${{Auth::user()->received_amount}}</a>
                        </div>
                        <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                            <a href="#" class="" style="margin:20px;">Messages Sent: ${{Auth::user()->responded_amount}}</a>
                        </div>
                        <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                            <a href="#" class="" style="margin:20px;">Messages Responded: ${{Auth::user()->sent_amount}}</a>
                        </div>


                        <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                            <a href="{{url('/profile')}}" class="text-primary" style="margin:20px;">Profile
                                {{--<span class="badge badge-pill up danger"></span>--}}
                            </a>
                        </div>

                        <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                            <a href="{{url('/settings')}}" class="text-primary" style="margin:20px;">Settings
                                {{--<span class="badge badge-pill up danger"></span>--}}
                            </a>
                        </div>

                        <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                            <a href="{{url('/logout')}}" class="text-primary" style="margin:20px;">Log Out
                                {{--<span class="badge badge-pill up danger"></span>--}}
                            </a>
                        </div>


                        <div class="nav-lg-none no-grow order-lg-1" id="nav-item-avatar">
                            <ul class="nav flex-row order-lg-2">
                                <!-- Notification -->

                                {{--<li class="d-lg-none d-flex align-items-center">--}}
                                    {{--<a href="#" class="mx-2" data-toggle="collapse" data-target="#navbarToggler">--}}
                                        {{--<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"--}}
                                             {{--viewBox="0 0 512 512">--}}
                                            {{--<path d="M64 144h384v32H64zM64 240h384v32H64zM64 336h384v32H64z"/>--}}
                                        {{--</svg>--}}
                                    {{--</a>--}}
                                {{--</li>--}}

                                <!-- User dropdown menu -->
                                <li class="dropdown d-flex align-items-center">
                                    <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                                        <span class="avatar w-32">
                                          <img src="{{Auth::user()->photo}}">
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn">

                                        <a class="dropdown-item" href="{{url('/profile')}}">
                                            <span>Profile</span>
                                        </a>

                                        <span class="dropdown-item">
                                            Messages Received: ${{Auth::user()->received_amount}}
                                        </span>
                                        <span class="dropdown-item">
                                            Messages Sent: ${{Auth::user()->responded_amount}}
                                        </span>
                                        <span class="dropdown-item">
                                            Messages Responded: ${{Auth::user()->sent_amount}}
                                        </span>


                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="{{url('/logout')}}">Sign out</a>
                                    </div>
                                </li>
                                <!-- Navarbar toggle btn -->

                            </ul>
                        </div>

                    </div>



                    @else
                        <a href="#" class="mx-2 d-sm-none" data-toggle="collapse" data-target="#navbarToggler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 512 512">
                                <path d="M64 144h384v32H64zM64 240h384v32H64zM64 336h384v32H64z"/>
                            </svg>
                        </a>

                        <div class="collapse navbar-collapse no-grow order-lg-1" id="navbarToggler"
                             style="align-items: baseline;">
                            <h5 style="margin:20px;"><a href="{{url('/')}}">Are you a creator?</a></h5>

                            <h5><a href="{{url('/find')}}" class="text-primary" style="margin:20px;">Find&nbsp;a&nbsp;creator</a>
                            </h5>

                            <a href="{{url('/register')}}" class="btn btn-rounded btn-sm primary btn-theme"
                               style="margin:20px;">
                                Sign Up
                            </a>

                            <a href="{{url('/login')}}" class="btn btn-outline btn-sm b-primary text-primary btn-theme"
                               style="margin: 20px; padding-left:10px; padding-right:10px;">
                                Log In
                            </a>
                        </div>
                        @endauth

            </div>


        </div>

    </div>
</div>
<!-- Main -->
<div class="content-main " id="content-main">


    @yield('content')


    <div class="item">
        <div class="p-0">
            <div class="footer">
                <div>
                    <img src="<?=asset('image/social_facebook.png')?>">
                    <img src="<?=asset('image/social_google.png')?>">
                    <img src="<?=asset('image/social_twitter.png')?>">
                    <img src="<?=asset('image/social_tumblr.png')?>">
                    <img src="<?=asset('image/social_pinterest.png')?>">
                </div>

                <div class="footer-legals">
                    <a href="{{url('/contact')}}">Contact us</a>
                    <a href="{{url('/terms')}}">Terms of use</a>
                    <a href="{{url('/privacy')}}">Privacy policy</a>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- ############ SWITHCHER END-->

<!-- build:js scripts/app.min.js -->
<!-- jQuery -->
<script src="<?=asset('libs/jquery/dist/jquery.min.js')?>"></script>
<!-- Bootstrap -->
<script src="<?=asset('libs/popper.js/dist/umd/popper.min.js')?>"></script>
<script src="<?=asset('libs/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- core -->
<script src="<?=asset('libs/pace-progress/pace.min.js')?>"></script>
<script src="<?=asset('libs/pjax/pjax.js')?>"></script>

<script src="<?=asset('scripts/lazyload.config.js')?>"></script>
<script src="<?=asset('scripts/lazyload.js')?>"></script>
<script src="<?=asset('scripts/plugin.js')?>"></script>
<script src="<?=asset('scripts/nav.js')?>"></script>
<script src="<?=asset('scripts/scrollto.js')?>"></script>
<script src="<?=asset('scripts/toggleclass.js')?>"></script>
<script src="<?=asset('scripts/theme.js')?>"></script>
<script src="<?=asset('scripts/ajax.js')?>"></script>
<script src="<?=asset('scripts/app.js')?>"></script>
<!-- endbuild -->
@yield('script')
</body>
</html>
