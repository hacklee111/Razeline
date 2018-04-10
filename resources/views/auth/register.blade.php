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
            <div class="col-md-6 offset-md-3 col-sm-10 offset-sm-1">
                <div class="panel panel-default m-auto panel-login">

                    <div class="panel-heading text-center"><h2>Sign Up</h2></div>

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
                            <div class="fb-login-button hide" data-width="400px" data-max-rows="1" data-size="large"
                                 data-height="50px"
                                 data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false"
                                 data-use-continue-as="false"></div>

                            <button class="fb-login-button2" type="submit" onclick="FB.login()"><i class="fa fa-facebook-f"></i>Continue With Facebok</button>

                        </div>

                        <div class="form-label-group text-center mt-4 mb-4">
                            <p>or sign up with e-mail</p>
                        </div>


                        <form class="form-horizontal form-signin" method="POST" action="{{ route('register') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-label-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                <input id="name" type="text" class="form-control" name="name" placeholder="Full Name"
                                       value="{{ old('name', isset($name) ? $name : "") }}" required autofocus>

                                <label for="name" class="control-label">Full Name<span
                                            class="asterisk">*</span></label>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-label-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <input id="email" type="email" class="form-control" name="email" placeholder="Email"
                                       value="{{ old('email', isset($email) ? $email : "") }}" required>
                                <label for="email" class="control-label">E-Mail Address<span
                                            class="asterisk">*</span></label>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            @if(!isset($social))
                                <div class="form-label-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                    <input id="password" type="password" class="form-control" name="password"
                                           placeholder="Password"
                                           required>

                                    <label for="password" class="control-label">Password<span class="asterisk">*</span></label>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-label-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required placeholder="Confirm Password">
                                    <label for="password-confirm" class="control-label">Confirm Password<span
                                                class="asterisk">*</span></label>
                                </div>
                            @endif

                            <div class="form-label-group">
                                <input type="text" id="birthday" name="birthday" class="form-control mb-3"
                                       placeholder="Birthday"
                                       data-plugin="datepicker" data-option="{autoclose: true}" required>
                                <label for="birthday" class="control-label">Birthday</label>
                            </div>

                            <div class="form-group row no-gutters">

                                <label for="gender" class="control-label col-4">Gender</label>

                                <select name="gender" id="gender" class="form-control col-8">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>

                            </div>

                            <div class="form-group row no-gutters">
                                <label for="type" class="control-label col-4">User Type<span
                                            class="asterisk">*</span></label>

                                <select name="type" id="type" class="form-control col-8">
                                    <option value="creator">Creator</option>
                                    <option value="fan">Fan</option>
                                </select>

                            </div>

                            <div class="form-label-group{{ $errors->has('profession') ? ' has-error' : '' }}" id="group_profession">

                                <input id="profession" type="text" class="form-control hide_require" name="profession"
                                       placeholder="Heading"
                                       value="{{ old('profession', isset($heading) ? $heading : "") }}" required>

                                <label for="profession" class="control-label">Heading<span
                                            class="asterisk">*</span></label>

                                @if ($errors->has('profession'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profession') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row no-gutters" id="group_description">
                                <label for="description" class="control-label col-4">Description<span
                                            class="asterisk">*</span></label>
                                <textarea id="description" name="description" class="form-control col-8" required></textarea>
                            </div>

                            <div class="form-group row no-gutters" id="group_rate">

                                <label for="rate" class="control-label col-4">Rate<span
                                            class="asterisk">*</span></label>

                                <input type="number" id="rate" name="rate" class="form-control col-8" min="5"
                                       max="1000" required step="1"
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57">


                            </div>

                            <div class="form-group row no-gutters" id="group_do_not_send">
                                <label for="do_not_send" class="control-label col-4">Do not send<span
                                            class="asterisk">*</span></label>

                                <textarea id="do_not_send" name="do_not_send" class="form-control col-8"
                                          required></textarea>
                            </div>

                            <div class="form-group row no-gutters">
                                <label for="file" class="control-label col-4">Profile Picture</label>
                                <div class="form-file col-8">
                                    <input id="f01" type="file" name="photo" class="form-control hide"
                                           placeholder="Add profile picture"/>
                                    <label for="f01" class="btn btn-secondary">Upload File</label>
                                </div>
                            </div>

                            <div class="form-group row no-gutters">
                                <label for="file" class="control-label col-4">Profile Background</label>
                                <div class="form-file col-8">
                                    <input id="f02" type="file" name="background" class="form-control hide"
                                           placeholder="Add profile background"/>
                                    <label for="f02" class="btn btn-secondary">Upload File</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary btn-block">
                                SIGN UP
                            </button>

                            <h6 class="text-center mt-3"><a class="btn-link" href="{{url('/login')}}">Log in</a></h6>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function () {
            function onChangeUserType() {
                var value = document.getElementById('type').value;

                if (value === 'creator') {
                    document.getElementById('group_profession').style.display = 'block';
                    document.getElementById('group_description').style.display = 'block';
                    document.getElementById('group_rate').style.display = 'block';
                    document.getElementById('group_do_not_send').style.display = 'block';

                    document.getElementById('profession').setAttribute('required', 'required');
                    document.getElementById('description').setAttribute('required', 'required');
                    document.getElementById('rate').setAttribute('required', 'required');
                    document.getElementById('do_not_send').setAttribute('required', 'required');

                } else {
                    document.getElementById('group_profession').style.display = 'none';
                    document.getElementById('group_description').style.display = 'none';
                    document.getElementById('group_rate').style.display = 'none';
                    document.getElementById('group_do_not_send').style.display = 'none';

                    //remove require
                    document.getElementById('profession').removeAttribute('required');
                    document.getElementById('description').removeAttribute('required');
                    document.getElementById('rate').removeAttribute('required');
                    document.getElementById('do_not_send').removeAttribute('required');

                }
            }

            $('#type').on("change", onChangeUserType);

        });

        //        var init = function() {
        //            $('#birthday').datetimepicker({ locale: 'en-ca' });
        //        };
        //        $.fn.datetimepicker.init = init;


        $("[type=file]").on("change", function () {
            // Name of file and placeholder
            var file = this.files[0].name;
            var dflt = $(this).attr("placeholder");
            if ($(this).val() != "") {
                $(this).next().text(file);
            } else {
                $(this).next().text(dflt);
            }
        });

    </script>
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