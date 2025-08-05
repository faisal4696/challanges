<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilestonsComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','challange_id','mileston_id','description'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function challange()
    {
    	return $this->belongsTo(Challange::class);
    }

    public function mileston()
    {
    	return $this->belongsTo(Mileston::class);
    }
    public function milestonReply()
    {
        return $this->hasMany(MilestonsReply::class);
    }
}
