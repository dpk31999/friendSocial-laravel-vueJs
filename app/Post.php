<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id','title','url_image'];

    // relationship

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
