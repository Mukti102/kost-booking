<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = ['id'];

    public function booking(){
        return $this->belongsTo(Booking::class,'booking_id');
    }

    public function typePayment(){
        return $this->belongsTo(TypePayment::class,'type_payment_id');
    }
}
