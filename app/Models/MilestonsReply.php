<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilestonsReply extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','mileston_id','milestons_comment_id','description'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function mileston()
    {
    	return $this->belongsTo(Mileston::class);
    }

    public function challangeComment()
    {
    	return $this->belongsTo(MilestonsComment::class);
    }
}
