<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antenna extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'antenna_code',
        'brand_model',
        'frequency',
        'install_location',
        'client_count',
        'max_clients',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'client_count' => 'integer',
        'max_clients' => 'integer',
        'sort_order' => 'integer',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }
}
