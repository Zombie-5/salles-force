<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = ['name', 'function', 'price', 'income', 'duration', 'isActive'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'machine_user', 'machine_id', 'user_id');
    }
}
