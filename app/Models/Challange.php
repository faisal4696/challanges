<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challange extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','category_id','title','description'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
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

    public function challangeReply()
    {
        return $this->hasMany(ChallangesReply::class);
    }
}
