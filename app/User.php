<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject //, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password','country','city','date_of_birth','status','url_avatar','phone','link_fb'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    /**
     * Get the oauth providers. 
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // relationship

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function friendRequest()
    {
        return $this->belongsToMany(User::class,Friend::class,'from','to')->wherePivot('status','=', 1);    
    }

    public function friendAccept()
    {
        return $this->belongsToMany(User::class,Friend::class,'to','from')->wherePivot('status','=', 1);
    }

    public function requestFriend()
    {
        return $this->belongsToMany(User::class,Friend::class,'from','to')->wherePivot('status','=', 0);
    }

    public function inviteFriend()
    {
        return $this->belongsToMany(User::class,Friend::class,'to','from')->wherePivot('status','=', 0);
    }

    public function interests()
    {
        return $this->belongstoMany(Interest::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'from');
    }
}
