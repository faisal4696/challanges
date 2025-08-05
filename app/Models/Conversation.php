<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['sender_id','receiver_id','deleted_by'];
    protected $dates = ['deleted_at'];

    public function sender()
    {
    	return $this->belongsTo(User::class); 
    }

    public function receiver()
    {
    	return $this->belongsTo(User::class); 
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

    public function lastmsg()
    {
        return $this->hasOne(Chat::class)->latest('id');
    }
}
