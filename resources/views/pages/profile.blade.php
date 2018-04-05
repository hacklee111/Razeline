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
    <div class="item">
        <div class="img-bg">
            <img src="{{$user->background}}" alt=".">
        </div>
        <div class="section-profile">
            <div class="section-profile-header">
                <p>
                    @if($user->me)
                    My Profile
                        @else
                    {{$user->name}}
                        @endif
                </p>
                <hr>
            </div>
            <div class="section-profile-body">
                <div class="section-profile-left">
                    <div class="pos-rlt text-center">
                        <img src="{{$user->photo}}" alt="." class="photo save-aspect">
                    </div>
                    @if(!$user->me)
                    <a class="md-btn md-raised mb-2 w-md green" href="{{url('/messages')}}?user={{$user->id}}"><i class="fa fa-comment-o"></i>&nbsp;&nbsp;Message</a>
                        @endif
                </div>
                <div class="section-profile-right">
                    <span style="display:flex; justify-content: space-between;">
                        <strong>{{$user->name}}</strong>
                        @if($user->me)
                        <a href="{{url('/settings')}}"><i class="fa fa-edit align-right"></i></a>
                        @endif
                    </span>


                    @if($user->type == 'creator')
                    <div class="">
                        {{$user->profession}}
                    </div>


                    @if($user->me)
                    <div class="" style="color: #000; margin-top: 30px; font-size: 12pt;">
                        <i class="fa fa-user"></i> &nbsp;About
                    </div>
                    <hr>
                    @endif

                    @if($user->me)
                    <strong>Description</strong>
                    @endif
                    <br>
                    {{$user->description}}<br><br>

                    <strong>Rate</strong><br>
                    ${{$user->rate}}<br><br>

                    <strong>Do not send</strong><br>
                    {{$user->do_not_send}}<br><br>

                    @else

                    <div class="" style="color: #000; margin-top: 30px; font-size: 12pt;">
                        <i class="fa fa-user"></i> &nbsp;About
                    </div>
                    <hr>

                    <span style="display:inline-block; width: 150px;"><strong>Date of birth</strong></span>
                    {{$user->birthday}}<br><br>

                    <span style="display:inline-block; width: 150px;"><strong style="min-width: 150px;">Gender</strong></span>
                    {{$user->gender}}<br><br>

                    <span style="display:inline-block; width: 150px;"><strong>Education</strong></span>
                    {{$user->education}}<br><br>

                    <span style="display:inline-block; width: 150px;"><strong>Profession</strong></span>
                    {{$user->profession}}<br><br>

                    <strong>Description</strong><br>
                    {{$user->description}}<br><br>

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection

