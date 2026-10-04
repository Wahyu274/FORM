<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'instance_name',
        'address',
        'regency',
        'province',
        'pic_name',
        'pic_position',
        'pic_phone',
        'pic_email',
        'distance_km',
        'distance_unit',
        'access_mode',
        'road_condition',
        'vehicle_type',
        'travel_time',
        'latitude',
        'longitude',
        'access_notes',
    ];

    protected $casts = [
        'distance_km' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }
}
