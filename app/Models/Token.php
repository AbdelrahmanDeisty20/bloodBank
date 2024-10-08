<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model 
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = array('token', 'type');

    public function clients()
    {
        return $this->hasOne('App\Models\Client');
    }

}