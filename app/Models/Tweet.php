<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Client;

class Tweet extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(TwitterUser::class);
    }

    public function media(){
        return $this->hasMany(Media::class);
    }

    public function hashtags(){
        return $this->belongsToMany(Hashtag::class);
    }
}
