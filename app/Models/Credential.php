<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $fillable = [
        'bsc_private_key',
        'wallet_address',
        'mnemonic',
    ];

    protected $hidden = [
        'bsc_private_key',
        'mnemonic',
    ];
} 