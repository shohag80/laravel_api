<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Token;

class Passport extends Token
{
    protected $keyType = 'string';
    public $incrementing = false;
}
