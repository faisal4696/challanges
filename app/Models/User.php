<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'signup_type',
        'points',
        'image',
        'device_id',
        'status',
        'last_seen',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function challange()
    {
        return $this->hasMany(Challange::class);
    }

    public function challangeComment()
    {
        return $this->hasMany(ChallangesComment::class);
    }

    public function mileston()
    {
        return $this->hasMany(Mileston::class);
    }

    public function milestonComment()
    {
        return $this->hasMany(MilestonsComment::class);
    }

    public function challangeLike()
    {
        return $this->hasMany(ChallangesLike::class);
    }

    public function milestonLike()
    {
        return $this->hasMany(MilestonsLike::class);
    }

    public function conversation()
    {
        return $this->hasMany(Conversation::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }

    public function challangeReply()
    {
        return $this->hasMany(ChallangesReply::class);
    }

    public function milestonReply()
    {
        return $this->hasMany(MilestonsReply::class);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }
}
