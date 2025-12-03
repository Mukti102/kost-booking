<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_fasilities');
    }

}
