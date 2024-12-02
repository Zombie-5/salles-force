<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'telefone',
        'password',
        'userId'
    ];

    public function banco()
    {
        return $this->hasOne(Banco::class); // Relacionamento 1:1 com Banco
    }

    /* public function machines()
    {
        return $this->belongsToMany(Machine::class, 'machine_user', 'user_id', 'machine_id');
    } */

    public function machines()
    {
        return $this->belongsToMany(Machine::class)->withPivot([
            'remainingToday',
            'remainingTotal',
            'incomeToday',
            'incomeTotal',
            'created_at'
        ]);
    }
}
