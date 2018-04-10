@extends('layouts.app')

@section('header')
    <style>
        .img-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .img-bg img {
            width: 100%;
            min-height: 500px;
        }

        .row-about {
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')

    <div class="full-ob bg-cover" style="background-image:url({{$user->background}});">

        <div class="container section-profile full-ob">
            <div class="row pt-3 pb-5">
                <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2">
                    <h2 class="profile-name text-center">
                        @if($user->me)
                            My Profile
                        @else
                            {{$user->name}}
                        @endif
                    </h2>
                    <hr>
                </div>
            </div>

            <div class="row py-3">
                <div class="col-md-5 col-sm-6">
                    <div class="pos-rlt text-center">
                        <img src="{{$user->photo}}" alt="." class="profil-photo save-aspect img-responsive">
                    </div>
                    <div class="text-center mt-5">
                        @if(!$user->me)
                            <a class="md-btn md-raised mb-2 w-md green"
                               href="{{url('/messages')}}?user={{$user->id}}"><i
                                        class="fa fa-comment-o"></i>&nbsp;&nbsp;Message</a>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-sm-6">

                    <div class="d-flex flex-wrap" style="justify-content: space-between;">

                        <h4>{{$user->name}}</h4>
                        @if($user->me)
                            <a href="{{url('/settings')}}" class="edit-profile-link"><i
                                        class="fa fa-edit align-right"></i></a>
                        @endif
                    </div>


                    @if($user->type == 'creator')
                        <div class="row py-2">
                            <p class="col-md-12"> {{$user->profession}}</p>
                        </div>

                        <div class="row py-2">
                            <p class="col-md-12">{{$user->description}}</p>
                        </div>


                        <div class="row py-2">
                            <div class="col-sm-4">
                                <h5>Rate:</h5>
                            </div>
                            <div class="col-md-8"><p>${{$user->rate}}</p></div>
                        </div>

                        <div class="row py-2">
                            <div class="col-sm-4">
                                <h5>Do not send:</h5>
                            </div>
                            <div class="col-md-8">
                                <p>{{$user->do_not_send}}</p>
                            </div>
                        </div>

                    @else

                        <div class="row py-2">
                            <div class="col-sm-4">
                                <h5>Date of birth:</h5>
                            </div>
                            <div class="col-md-8"><p>{{$user->birthday}}</p></div>
                        </div>

                        <div class="row py-2">
                            <div class="col-sm-4">
                                <h5>Gender:</h5>
                            </div>
                            <div class="col-md-8">
                                <p>{{$user->gender}}</p>
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col-sm-4">
                                <h5>Education:</h5>
                            </div>
                            <div class="col-md-8"><p>{{$user->education}}</p></div>
                        </div>

                        <div class="row py-2">
                            <div class="col-sm-4">
                                <h5>Profession:</h5>
                            </div>
                            <div class="col-md-8">
                                <p>{{$user->profession}}</p>
                            </div>
                        </div>

                        <div class="row py-2">
                            <p class="col-md-12">{{$user->description}}</p>
                        </div>

                    @endif

                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')

@endsection

