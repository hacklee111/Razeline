@extends('layouts.app')
@section('header')
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id"
          content="4889135096-s54r15vij6n1nnftr2lmgkbr7ckr6cpa.apps.googleusercontent.com">

    <link rel="stylesheet" href="<?=asset('assets/css/floatlabel.css')?>" type="text/css"/>
@endsection

@section('content')
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-md-8 offset-md-2 col-sm-10 offset-sm-1">

                <div class="panel panel-default m-auto panel-login">

                    <div class="panel-heading text-center"><h2>Login</h2></div>

                    <div class="panel-body bg-white p-2">

                        <div class="form-signin">

                            <div class="g-signin2 form-label-group"
                                 data-width="430" data-height="50"
                                 data-onsuccess="onSignIn" data-theme="dark"></div>

                            <script>
                                // This is called with the results from from FB.getLoginStatus().
                                function statusChangeCallback(response) {
                                    console.log('statusChangeCallback');
                                    console.log(response);
                                    // The response object is returned with a status field that lets the
                                    // app know the current login status of the person.
                                    // Full docs on the response object can be found in the documentation
                                    // for FB.getLoginStatus().
                                    if (response.status === 'connected') {
                                        // Logged into your app and Facebook.
                                        testAPI();
                                    } else {
                                        // The person is not logged into your app or we are unable to tell.
                                        document.getElementById('status').innerHTML = 'Please log ' +
                                            'into this app.';
                                    }
                                }

                                // This function is called when someone finishes with the Login
                                // Button.  See the onlogin handler attached to it in the sample
                                // code below.
                                function checkLoginState() {
                                    FB.getLoginStatus(function (response) {
                                        statusChangeCallback(response);
                                    });
                                }

                                window.fbAsyncInit = function () {
                                    FB.init({
                                        appId: '130127590512253',
                                        cookie: true,  // enable cookies to allow the server to access
                                                       // the session
                                        xfbml: true,  // parse social plugins on this page
                                        version: 'v2.8' // use graph api version 2.8
                                    });

                                    // Now that we've initialized the JavaScript SDK, we call
                                    // FB.getLoginStatus().  This function gets the state of the
                                    // person visiting this page and can return one of three states to
                                    // the callback you provide.  They can be:
                                    //
                                    // 1. Logged into your app ('connected')
                                    // 2. Logged into Facebook, but not your app ('not_authorized')
                                    // 3. Not logged into Facebook and can't tell if they are logged into
                                    //    your app or not.
                                    //
                                    // These three cases are handled in the callback function.

                                    FB.getLoginStatus(function (response) {
                                        statusChangeCallback(response);
                                    });

                                };

                                // Load the SDK asynchronously
                                (function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "https://connect.facebook.net/en_US/sdk.js";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));

                                // Here we run a very simple test of the Graph API after login is
                                // successful.  See statusChangeCallback() for when this call is made.
                                function testAPI() {
                                    console.log('Welcome!  Fetching your information.... ');
                                    FB.api('/me', function (response) {
                                        console.log('Successful login for: ' + response.name);
                                        document.getElementById('status').innerHTML =
                                            'Thanks for logging in, ' + response.name + '!';
                                    });
                                }
                            </script>

                            <div id="fb-root"></div>
                            <div class="fb-login-button hide" data-width="400" data-height="40" data-max-rows="1" data-size="large"
                                 data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false"
                                 data-use-continue-as="false"></div>

                            <button class="fb-login-button2" type="submit" onclick="FB.login()"><i class="fa fa-facebook-f"></i>Continue With Facebok</button>

                        </div>

                        <div class="form-label-group text-center mt-4 mb-4">
                            <p>or login with email</p>
                        </div>


                        <form class="form-horizontal form-signin" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-label-group {{ $errors->has('email') ? 'has-error' : '' }}">

                                <input id="email" type="email" class="form-control" name="email"
                                       placeholder="Email address"
                                       value="{{ old('email') }}" required autofocus>

                                <label for="email" class="control-label">E-Mail Address</label>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-label-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" required
                                       placeholder="Password">
                                <label for="password" class="control-label">Password</label>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">

                                    <div class="checkbox p-2">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> Remember
                                            Me
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-6 text-right">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary btn-block">
                                LOGIN
                            </button>

                            <h6 class="text-center mt-3"> New to Razeline? <a class="btn-link" href="{{url('/register')}}">Sign Up</a></h6>

                        </form>

                        <form id="form-google-sign" method="post" action="{{url('/google-sign')}}">
                            {{ csrf_field() }}
                            <input type="hidden" id="form_name" name="name" value="">
                            <input type="hidden" id="form_photo_url" name="photo_url">
                            <input type="hidden" id="form_email" name="email">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://apis.google.com/js/platform.js"></script>
    <script>
        function onSignIn(googleUser) {
            // Useful data for your client-side scripts:
            var profile = googleUser.getBasicProfile();
            console.log("ID: " + profile.getId()); // Don't send this directly to your server!
            console.log('Full Name: ' + profile.getName());
            console.log('Given Name: ' + profile.getGivenName());
            console.log('Family Name: ' + profile.getFamilyName());
            console.log("Image URL: " + profile.getImageUrl());
            console.log("Email: " + profile.getEmail());

            // The ID token you need to pass to your backend:
            var id_token = googleUser.getAuthResponse().id_token;
            console.log("ID Token: " + id_token);

            var form = $('#form-google-sign');
            document.getElementById("form_name").value = profile.getName();
            document.getElementById("form_photo_url").value = profile.getImageUrl();
            document.getElementById("form_email").value = profile.getEmail();

            form.submit();
        };
    </script>
@endsection