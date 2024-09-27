<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    /**
     * Get the client that owns the favourite.
     */
    public function client()
    {
        return $this->hasMany(Client::class);
    }
}
