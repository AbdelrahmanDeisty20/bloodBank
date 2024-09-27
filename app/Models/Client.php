<?php

namespace App\Models;

use App\Models\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'birth_date','is_active','blood_type_id','city_id','donation_last_date','pin_code', 'password', 'phone');

    public function setPasswordAttribute($value)
{
    $this->attributes['password'] = bcrypt($value);
}
    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodTypes');
    }

    public function clientPatient()
    {
        return $this->belongsTo('App\Models\Donation');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }
    public function favourites()
    {
        return $this->belongsToMany('App\Models\Post');
    }

    public function governorate()
    {
        return $this->belongsTo('App\Models\Governorate');
    }

    public function bloodTypes()
    {
        return $this->belongsToMany('App\Models\BloodType');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }
    public function requests()
{
    return $this->hasMany('App\Models\DonationRequest');
}
public function city()
{
    return $this->belongsTo('App\Models\City');
}
}
