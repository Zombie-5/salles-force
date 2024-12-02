<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $fillable = ['name', 'owner', 'iban', 'user_id', 'isAdmin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
