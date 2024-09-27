<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array(
        'about_address',
        'about_app',
        'phone',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'youtube_link',
        'email'
    );
}
