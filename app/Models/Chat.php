<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['conversation_id','sender_id','receiver_id','message','attachment','deleted_by'];
    protected $dates = ['deleted_at'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
    	return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
    	return $this->belongsTo(User::class,'receiver_id');
    }

}
