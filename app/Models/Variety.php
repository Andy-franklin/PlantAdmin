<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    use HasFactory;

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
