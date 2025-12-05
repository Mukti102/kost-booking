<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'number',
        'tarif',
        'status',
        'description',
        'name',
        'kamar_tersedia',
        'duration',
    ];

    public function fasilities()
    {
        return $this->belongsToMany(Fasility::class, 'room_fasilities');
    }

    public function images(){
        return $this->hasMany(Images::class,'room_id');
    }
}
