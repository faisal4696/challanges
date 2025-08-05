<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mileston extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','challange_id','title','description','status'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function challange()
    {
    	return $this->belongsTo(Challange::class);
    }

    public function milestonComment()
    {
        return $this->hasMany(MilestonsComment::class);
    }

    public function milestonLike()
    {
        return $this->hasMany(MilestonsLike::class);
    }

    public function milestonReply()
    {
        return $this->hasMany(MilestonsReply::class);
    }
}
