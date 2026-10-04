<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'device_type',
        'brand',
        'model',
        'quantity',
        'specs',
        'condition',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }
}
