<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_image',
        'name',
        'uuid',
        'status',
        'variety',
        'filial_generation',
        'fatherParent',
        'motherParent',
        'pot_size'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function variety(): BelongsTo
    {
        return $this->belongsTo(Variety::class);
    }

    public function motherParent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'mother_parent');
    }

    public function fatherParent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'father_parent');
    }

    public function scopeChildren($query)
    {
        return $query->where('mother_parent', $this->id)
            ->orWhere('father_parent', $this->id);
    }
}
