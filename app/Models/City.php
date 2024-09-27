<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name','governorate_id');

    public function cities()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function governateType()
    {
        return $this->belongsTo('App\Models\Governorate');
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function requests()
    {
        return $this->hasMany(DonationRequest::class);
    }

}
