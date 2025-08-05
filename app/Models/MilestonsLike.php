<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilestonsLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','mileston_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function mileston()
    {
    	return $this->belongsTo(Mileston::class);
    }
}
