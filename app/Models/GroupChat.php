<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;

    protected $table = 'group_chats';

    protected $fillable = ['user_id', 'group_id', 'from', 'name', 'is_read', 'message'];




    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
       return $this->belongsTo(Group::class);
    }


}
