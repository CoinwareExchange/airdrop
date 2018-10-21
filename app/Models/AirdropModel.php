<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirdropModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;

    protected $table = 'users_air';

    protected $fillable = [
        'tel_user_name', 'email_address','eth_address','verify_telegram','twitter_user','verify_twitter','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
