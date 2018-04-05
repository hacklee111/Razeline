<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MessageChannel extends Model
{
    protected $fillable = [
        'creator_id', 'fan_id', 'last_message', 'unreads'
        ];

    protected $appends = [
        'creator_name', 'creator_photo', 'fan_name', 'fan_photo',
        'opponent_name', 'opponent_photo',
        'need_pay'
    ];

    public $timestamps = true;

    public $table = 'message_channels';

    public function getCreatorNameAttribute() {
        $creator = User::find($this->creator_id);
        return $creator->name;
    }

    public function getCreatorPhotoAttribute() {
        $creator = User::find($this->creator_id);
        return $creator->photo;
    }

    public function getFanNameAttribute() {
        $fan = User::find($this->fan_id);
        return $fan->name;
    }

    public function getFanPhotoAttribute() {
        $fan = User::find($this->fan_id);
        return $fan->photo;
    }

    public function getOpponentNameAttribute() {
        $me = Auth::user();
        $mi = $me->id;

        return $this->creator_id == $mi ? $this->fan_name : $this->creator_name;
    }

    public function getOpponentPhotoAttribute() {
        $me = Auth::user();
        $mi = $me->id;

        return $this->creator_id == $mi ? $this->fan_photo : $this->creator_photo;
    }

    public function getNeedPayAttribute() {
        $me = Auth::user();
        $mi = $me->id;

        if($this->creator_id == $mi) {
            return false;
        }

        if($me->subscription_available) {
            return false;
        }

        return true;
    }
}
