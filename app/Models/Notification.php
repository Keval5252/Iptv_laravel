<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->hasMany(User::class,'id','to_user')->select('id','name','last_name','photo');
    }
}
