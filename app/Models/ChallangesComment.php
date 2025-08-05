<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallangesComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','challange_id','time','description','attachment'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function challange()
    {
    	return $this->belongsTo(Challange::class);
    }

    public function challangeReply()
    {
        return $this->hasMany(ChallangesReply::class);
    }
}
