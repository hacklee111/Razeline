@extends('layouts.app')
@section('header')
@endsection
@section('content')
    <div class="d-flex flex full-ob" data-plugin="chat">
        <div class="fade aside aside-sm" id="content-aside-chat">
            <div class="d-flex flex-column w-xl b-r b-r-3x white modal-dialog pt-3" id="chat-nav">
                <div class="scrollable hover">
                    <div class="list inset">

                        <div class="p-2 px-3 text-muted text-sm">Messages</div>

                        @foreach($channels as $c)
                            <div class="list-item @if($c->id == $active_channel->id) active @endif" data-id="item-14">
	      			            <span class="w-56 avatar circle brown">
                                    <a href="{{url('/profile').'?user='.base64_encode($c->fan_id)}}">
	      			                    <img src="{{url($c->opponent_photo)}}" class="img-cover w-56 circle" alt=".">
                                    </a>
	      			            </span>
                                <div class="list-body">
                                    <a href="{{url('/messages')}}?channel={{$c->id}}"
                                       class="item-title _500">{{$c->opponent_name}}</a>

                                    <div class="item-except text-sm text-muted h-1x">
                                        {{$c->last_message}}
                                    </div>

                                    <div class="item-tag tag hide">
                                    </div>
                                </div>
                                <div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="no-result hide">
                        <div class="p-4 text-center">
                            No Results
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="d-flex flex" id="content-body">
            <div class="d-flex flex-column flex" id="chat-list">
                <div class="navbar flex-nowrap white lt box-shadow">
                    <a data-toggle="modal" data-target="#content-aside-chat" data-modal class="mr-1 d-md-none">
					<span class="btn btn-sm btn-icon primary">
			      		<i class="fa fa-th"></i>
			        </span>
                    </a>

                    <span class="text-md text-ellipsis flex">
		        	    @if($active_channel)
                            {{$active_channel->fan_name}}
                        @endif
		            </span>
                </div>
                <div class="scrollable hover app-content">
                    <div class="p-3">
                        <div class="chat-list">
                            @if($active_channel)
                                @foreach($messages as $m)
                                    <div class="chat-item" @if($m->mine) data-class="alt" @endif >
                                        <a href="#" class="avatar w-40">
                                            <img src="{{url($m->sender_photo)}}" class="w-40 img-cover" alt=".">
                                        </a>
                                        <div class="chat-body">
                                            <div class="chat-content rounded msg">
                                                {{$m->message}}
                                            </div>

                                            <div class="chat-date date">
                                                {{$m->created_at}}
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        @endif
                        <!--
                            <div class="chat-item" data-class>
                                <a href="#" class="avatar w-40">
                                    <img class="image" src="../assets/images/a2.jpg" alt=".">
                                </a>
                                <div class="chat-body">
                                    <div class="chat-content rounded msg">
                                        Typing...
                                    </div>
                                    <div class="chat-date date">
                                        Just now
                                    </div>
                                </div>
                            </div>-->

                        </div>
                        <div class="hide">
                            <div class="chat-item" id="chat-item" data-class>
                                <a href="#" class="avatar w-40">
                                    <img class="image" src="{{asset('/assets/images/a0.jpg')}}" alt=".">
                                </a>
                                <div class="chat-body">
                                    <div class="chat-content rounded msg">
                                    </div>
                                    <div class="chat-date date"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 white lt b-t mt-auto" id="chat-form">
                    @if($active_channel)
                        <form method="post" action="{{url('/messages')}}/{{$active_channel->id}}/send" id="form-send">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group">
                                {{--<span class="input-group-btn">--}}
                                {{--<button class="btn white b-a no-shadow" type="button" id="emotionBtn">--}}
                                {{--<i class="fa fa-smile-o text-success"></i>--}}
                                {{--</button>--}}
                                {{--</span>--}}
                                <input type="text" class="form-control" placeholder="Message" id="newField"
                                       name="message" maxlength="140">
                                <span class="input-group-btn">
                                    <button class="btn white b-a no-shadow" type="button" id="newBtn">
                                        <i class="fa fa-send text-success"></i>
                                    </button>
		          	            </span>
                            </div>
                            <span id="max_warn"
                                  class="small text-info"
                                  style="display: none;">*MESSAGES CAN ONLY BE 140 CHARACTERS.</span>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
    <script>
        var pusher = new Pusher("be70bda4a0273ca4a552", {cluster: "us2", encrypted: true});

        Pusher.logToConsole = true;

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    </script>

    <script>

        $(document).ready(function () {
            //scroll down to last message
            if ($('.chat-list .chat-item').length > 0) {
                $('div.scrollable').animate({
                    scrollTop: $(".chat-list .chat-item:last-child").offset().top
                }, 2000);
            }

            //check character length
            $("#newField").on('input', function () {
                if ($(this).val().length >= 140) {
                    $('#max_warn').fadeIn('slow');
                } else {
                    $('#max_warn').fadeOut('slow');
                }
            });

        });
    </script>


    @if(!empty($active_channel))
        <script>
            window.chat = {};

            (function ($, list) {
                "use strict";

                var nav_el = "#chat-nav"
                    , list_el = "#chat-list"
                    , navlist
                    , list
                ;

                var channel = pusher.subscribe('chat{{$active_channel->id}}');
                channel.bind('new-message', function (data) {
                    create(data);
                });

                $(document).on('click', '#chat-form #newBtn', function (e) {
                    e.preventDefault();

                    send();
                });

                $(document).on('keypress', '#chat-form #newField', function (e) {
                    if (e.keyCode == 13) {
                        send();
                    }
                });


                function send() {
                    console.log("send");
                    var newField = $('#newField');
                    if (newField.val() !== '') {
                        var msg = newField.val();

                        @if($active_channel->need_pay)
                        console.log('submitting form');
                        var form = $('#form-send');

                        form.submit();
                        @else
                        console.log('sending ajax call');
                        $.ajax({
                            url: "{{url('/messages')}}/{{$active_channel->id}}/send",
                            type: 'POST',
                            data: {
                                'message': msg,
                            },
                            success: function (data) {
                                //waiting
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                notie.alert({type: 1, text: 'Failed to send chat'});
                                console.log(textStatus);
                            },
                            cache: false
                        });
                        @endif


                        $("#newField").val("");
                    }
                }


                function create(data) {

                    list.add({
                        msg: data.message,
                        date: data.created_at,
                        image: data.sender_photo,
                        class: data.sender_id == '{{Auth::user()->id}}' ? 'alt' : ''
                    });


                    gotoMsg();
                }

                function gotoMsg() {
                    $('.scrollable', list_el).animate({
                        scrollTop: $('.scrollable', list_el).prop("scrollHeight")
                    }, 1000, 'easeInOutExpo');
                }

                var init = function () {
                    $(document).trigger('refresh');

                    // nav
                    navlist = new List(nav_el.substr(1), {
                        valueNames: [
                            'item-title',
                            'item-except'
                        ]
                    });

                    // list
                    list = new List(list_el.substr(1), {
                        listClass: 'chat-list',
                        item: 'chat-item',
                        valueNames: [
                            'msg',
                            'date',
                            {data: ['class']},
                            {name: 'image', attr: 'src'}
                        ]
                    });

//                        notie.alert({type:1, text: 'Try say something' });

                }

                // for ajax to init again
                list.init = init;
            })(jQuery, window.chat);

        </script>
    @endif
@endsection