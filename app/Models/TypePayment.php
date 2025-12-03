<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    protected $fillable = [
        'name',
        'description',
        'no_rekening',
        'logo',
        'qris_url',
    ];
}
