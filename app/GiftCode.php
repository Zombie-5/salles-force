<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCode extends Model
{
    protected $fillable = ['token', 'value', 'status'];
}
