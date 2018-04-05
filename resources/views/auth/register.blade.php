@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <br>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', isset($name) ? $name : "") }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', isset($email) ? $email : "") }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(!isset($social))
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="birthday" class="col-md-4 control-label">Birthday</label>

                            <div class="col-md-6">
                                <input type="text" id="birthday" name="birthday" class="form-control mb-3" data-plugin="datepicker" data-option="{autoclose: true}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-md-4 control-label">Gender</label>

                            <div class="col-md-6">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="type" class="col-md-4 control-label">User Type<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <select name="type" id="type" class="form-control">
                                    <option value="creator">Creator</option>
                                    <option value="fan">Fan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="group_profession">
                            <label for="profession" class="col-md-4 control-label">Heading<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <input type="text" id="profession" name="profession" class="form-control mb-3" >
                            </div>
                        </div>

                        <div class="form-group" id="group_description">
                            <label for="description" class="col-md-4 control-label">Description<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <textarea id="description" name="description" class="form-control mb-3"></textarea>
                            </div>
                        </div>

                        <div class="form-group" id="group_rate">
                            <label for="rate" class="col-md-4 control-label">Rate<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <input type="number" id="rate" name="rate" class="form-control mb-3" min="5" max="1000"
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>

                        <div class="form-group" id="group_do_not_send">
                            <label for="do_not_send" class="col-md-4 control-label">Do not send<span class="asterisk">*</span></label>

                            <div class="col-md-6">
                                <textarea id="do_not_send" name="do_not_send" class="form-control mb-3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file"  class="col-md-4 control-label">Profile picture</label>
                            <div class="form-file col-md-6">
                                <input id="file" type="file" name="photo" class="form-control">
                                <button class="btn white">Upload new picture</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
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
                } else {
                    document.getElementById('group_profession').style.display = 'none';
                    document.getElementById('group_description').style.display = 'none';
                    document.getElementById('group_rate').style.display = 'none';
                    document.getElementById('group_do_not_send').style.display = 'none';
                }
            }

            $('#type').on("change", onChangeUserType);

        });

        var init = function() {
            $('#birthday').datetimepicker({ locale: 'en-ca' });
        };
        $.fn.datetimepicker.init = init;
    </script>
@endsection