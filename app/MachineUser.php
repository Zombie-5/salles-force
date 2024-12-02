<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineUser extends Model
{
    public $timestamps = true;
    protected $table = 'machine_user';
    
    protected $fillable = [
        'user_id',
        'machine_id',
        'remainingToday',
        'remainingTotal',
        'created_at',
    ];
}
