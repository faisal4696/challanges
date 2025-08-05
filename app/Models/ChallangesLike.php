<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallangesLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','challange_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function challange()
    {
    	return $this->belongsTo(Challange::class);
    }
}
