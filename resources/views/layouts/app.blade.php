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
<!-- scroll to top -->
<div id="top"></div>
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
                    <form class="input-group m-2 my-lg-0 header-search-form" method="get" action="{{url('/find')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <span class="input-group-btn">
		                        <button type="button" class="btn no-border no-bg no-shadow"><i class="fa fa-search"></i></button>
		                    </span>
                        <input type="text" class="form-control no-border no-bg no-shadow" name="keyword"
                               placeholder="Search">
                    </form>


                    <div class="no-grow order-lg-1 nav-menu-item">
                        <a href="{{url('/find')}}" class="text-primary"
                           style="margin:20px;">Find&nbsp;a&nbsp;creator</a>
                    </div>

                    <div class="no-grow order-lg-1 nav-menu-item">

                        <a href="{{url('/messages')}}" class="text-primary" style="margin:20px;">Messages</a>

                    </div>


                    <div class="no-grow order-lg-1 nav-menu-item d-sm-none">

                        <a href="#" class="text-primary" data-toggle="dropdown" style="margin:20px;">Balance</a>

                        <ul class="dropdown-menu  dropdown-menu-down animate fadeIn">
                            <li>
                                <a href="#" class="dropdown-item">Messages Received:
                                    ${{Auth::user()->received_amount}}</a>
                            </li>

                            <li>
                                <a href="#" class="dropdown-item">Messages Sent:
                                    ${{Auth::user()->responded_amount}}</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">Messages Responded:
                                    ${{Auth::user()->sent_amount}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                        <a href="{{url('/profile')}}" class="text-primary" style="margin:20px;">Profile
                        </a>
                    </div>

                    <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                        <a href="{{url('/settings')}}" class="text-primary" style="margin:20px;">Settings
                        </a>
                    </div>

                    <div class="d-sm-none no-grow order-lg-1 nav-menu-item">
                        <a href="{{url('/logout')}}" class="text-primary" style="margin:20px;">Log Out
                        </a>
                    </div>


                    <div class="nav-lg-none no-grow order-lg-1" id="nav-item-avatar">
                        <ul class="nav flex-row order-lg-2">
                            <li class="dropdown d-flex align-items-center">
                                <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                                        <span class="avatar w-32">
                                          <img src="{{Auth::user()->photo}}">
                                            <span
                                                    class="badge badge-pill up danger">{{Auth::user()->unread_messages}}</span>
                                        </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn">
                                    <li>
                                        <a class="dropdown-item" href="{{url('/profile')}}">
                                            <span>Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{url('/messages')}}">
                                            <span>Messages</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-item" data-toggle="dropdown"
                                           class="d-flex align-items-center">
                                            Balance
                                        </a>
                                        <ul class="dropdown-menu pt-0 w mt-0 animate fadeIn">
                                            <li>
                                                <span class="dropdown-item">
                                                    Messages Received: ${{Auth::user()->received_amount}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="dropdown-item">
                                                    Messages Sent: ${{Auth::user()->responded_amount}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="dropdown-item">
                                                    Messages Responded: ${{Auth::user()->sent_amount}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="dropdown-item">
                                                    Balance: ${{Auth::user()->balance_amount}}
                                                </span>
                                            </li>
                                        </ul>
                                    </li>

                                    <div class="dropdown-divider"></div>

                                    <li>
                                        <a class="dropdown-item" href="{{url('/logout')}}">Sign out</a>
                                    </li>
                                    <ul/>
                                    </li>
                                </ul>
                            </li>
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
                        <h5 style="margin:20px;" class="text-hover-primary"><a href="{{url('/')}}">Are you a
                                creator?</a></h5>

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
</div>

<div class="p-0">
    <div class="back-to-top-container">
        <h5>
            Back to top &nbsp;
        </h5>
        <a href="#top" data-scroll-to="top"><img src="<?=asset('image/back_to_top.png')?>"></a>
    </div>
</div>

<footer class="footer">
    <div class="content-footer row">
        <div class="col-md-6 footer-social text-lg-left text-center">
            <a href="#"><img src="<?=asset('image/social_facebook.png')?>"></a>
            <a href="#"><img src="<?=asset('image/social_google.png')?>"></a>
            <a href="#"><img src="<?=asset('image/social_twitter.png')?>"></a>
            <a href="#"><img src="<?=asset('image/social_tumblr.png')?>"></a>
            <a href="#"><img src="<?=asset('image/social_pinterest.png')?>"></a>
        </div>

        <div class="col-md-6 footer-legals text-lg-right text-center mt-4 mt-sm-0">
            <a href="{{url('/contact')}}">Contact us</a>
            <a href="{{url('/terms')}}">Terms of use</a>
            <a href="{{url('/privacy')}}">Privacy policy</a>
        </div>
    </div>
</footer>

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
