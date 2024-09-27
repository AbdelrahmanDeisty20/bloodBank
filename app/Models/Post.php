<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('title', 'content', 'image','category_id');
    protected $appends = array('thumbnail_full_path','is_favourite');

    public function category()
    {
        return $this->belongsTo('App\Models\CatgoryType');
    }
    public function getIsFavouriteAttribute()
{
    $favourites = $this->whereHas('favourites', function ($query) {
        $query->where('client_id', request()->user()->id);
        $query->where('post_id', $this->id);
    })->first();
    if ($favourites) {
        return true;
    }
    return false;
}

    public function getThumbNailFullPathAttrobute()
    {
        return asset($this->image);
    }


    public function favourites()
    {
        return $this->belongsToMany(Client::class);
    }
    public function client()
    {
        return $this->hasMany('App\Models\Client');
    }

}
