<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    protected $fillable = [
        'hospital_name',
        'patient_name',
        'patient_phone',
        'patient_age',
        'hospital_address',
        'blood_type_id',
        'bags_num',
        'details',
        'latitude',
        'longtude',
        'client_id',
        'city_id',
    ];
    protected $table = 'donation_requests';
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function notifications()
{
    return $this->hasMany(Notification::class, 'donation_request_id');
}
public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function bloodType()
    {
        return $this->belongsTo(BloodType::class, 'blood_type_id');
    }
}
