<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Job extends Model implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['title']; //use firstOrCreate()

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withTimestamps()->withPivot('is_selected','remark');
    }

//    public function user(){
//        return $this->belongsTo(User::class);
//    }

    public function categories(){
        return $this->belongsToMany(Category::class)
            ->withTimestamps()->withPivot('category_id');
    }

    public function images() {
        return $this->hasMany(Image::class);
    }


}
