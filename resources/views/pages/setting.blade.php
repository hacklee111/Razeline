@extends('layouts.app')

@section('header')
@endsection

@section('content')
    <div class="d-sm-flex" style="min-height: 500px">
        <div class="w w-auto-xs light bg bg-auto-sm b-r">
            <div class="py-3">
                <div class="nav-active-border left b-primary">
                    <ul class="nav flex-column nav-sm">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-toggle="tab" data-target="#tab-1">Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="#" data-toggle="tab" data-target="#tab-2">Security</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="#" data-toggle="tab" data-target="#tab-3">Subscribe</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="#" data-toggle="tab" data-target="#tab-4">Appearance</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col p-0">
            <div class="tab-content pos-rlt">
                <div class="tab-pane active" id="tab-1">
                    <div class="p-4 b-b _600">Public profile</div>
                    <form role="form" class="p-4 col-md-6" method="post" action="{{url('/profile')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Profile picture</label>
                            <div class="form-file">
                                <input type="file" name="photo">
                                <button class="btn white">Upload new picture</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label>Profession</label>
                            <input type="text" class="form-control" name="profession" id="profession" value="{{$user->profession}}">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" id="description" value="{{$user->description}}">
                        </div>

                        @if($user->type == 'creator')
                        <div class="form-group">
                            <label>Rate</label>
                            <input type="text" class="form-control" name="rate" id="rate"  value="{{$user->rate}}">
                        </div>
                        <div class="form-group">
                            <label>Do not send</label>
                            <input type="text" class="form-control" name="do_not_send" id="do_not_send"  value="{{$user->do_not_send}}">
                        </div>
                        @else

                        <div class="form-group">
                            <label for="birthday" class="col-md-4 control-label">Birthday</label>

                            <div class="col-md-6">
                                <input type="text" id="birthday" name="birthday" class="form-control mb-3" data-plugin="datepicker" data-option="{autoclose: true}" required
                                       value="{{$user->birthday}}"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-md-4 control-label">Gender</label>

                            <div class="col-md-6">
                                <select name="gender" id="gender" class="form-control">
                                    @if($user->gender == 'male')
                                    <option value="male" selected="selected"> Male</option>
                                    <option value="female">Female</option>
                                    @else
                                    <option value="male"> Male</option>
                                    <option value="female" selected="selected">Female</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Education</label>
                            <input type="text" class="form-control" name="education" id="education" value="{{$user->education}}">
                        </div>

                        @endif

                        <button type="submit" class="btn primary mt-2">Update</button>
                    </form>
                </div>


                <div class="tab-pane" id="tab-2">
                    <div class="p-4 b-b _600">Security</div>
                    <div class="p-4">
                        <div class="clearfix">
                            <form role="form" class="col-md-6 p-0" method="post" action="{{url('/profile')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label>New Password Again</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                                <button type="submit" class="btn primary mt-2">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-3">
                    <div class="p-4 b-b _600">Subscribe</div>
                    <div class="p-4">
                        <div class="clearfix">
                            {{--<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">--}}
                                {{--<input type="hidden" name="cmd" value="_s-xclick">--}}
                                {{--<input type="hidden" name="hosted_button_id" value="8773GMXCJ4KHW">--}}
                                {{--<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">--}}
                                {{--<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">--}}
                            {{--</form>--}}

                            @if(Auth::user()->subscription_available)
                                You already subscribed.
                            @else

                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="LG88SGG5BYHKG">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>

                            @endif

                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab-4">
                    <div class="p-4 b-b _600">Appearance</div>


                    <form role="form" class="p-4 col-md-6" method="post" action="{{url('/profile')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Profile background picture</label>
                            <div class="form-file">
                                <input type="file" name="background">
                                <button class="btn white">Upload new picture</button>
                            </div>
                        </div>

                        <button type="submit" class="btn primary mt-2">Update</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection