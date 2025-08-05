<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallangesReply extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','challange_id','challanges_comment_id','description'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function challange()
    {
    	return $this->belongsTo(Challange::class);
    }

    public function challangeComment()
    {
    	return $this->belongsTo(ChallangesComment::class);
    }
}
