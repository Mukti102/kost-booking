<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'gender',
        'phone',
        'address',
    ];


    public function booking(){
        return $this->hasOne(Booking::class,'tenant_id');
    }

    
}
