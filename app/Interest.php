<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = ['name','url_icon'];

    public function users()
    {
        return $this->belongstoMany(User::class);
    }

}
