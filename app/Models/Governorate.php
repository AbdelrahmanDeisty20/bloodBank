<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{

    protected $table = 'governorates';
    public $timestamps = true;
    protected $fillable = array('name');

    // public function cities()
    // {
    //     return $this->hasMany('App\Models\City');
    // }
    public function city()
    {
        return $this->hasMany('App\Models\City');
    }
    
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    // public function client()
    // {
    //     return $this->hasMany(Client::class);
    // }

}
