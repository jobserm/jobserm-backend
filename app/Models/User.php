<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function review() {
        return $this->hasMany(Review::class);
    }

    public function jobs() {
        return $this->belongsToMany(Job::class, 'job_user')->withPivot('remark', 'is_selected')
            ->withTimestamps();
    }

    public function isRole($role) :bool {
        return $this->role === $role;
    }

    public function isAdmin() :bool {
        return $this->isRole('ADMIN');
    }

    public function isUser() :bool {
        return $this->isRole('USER');
    }

//    public function getUsernameAttribute() {
//        return $this->username();
//    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
