<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['action', 'bancoId', 'money','status', 'userId'];
}
