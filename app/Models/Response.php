<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'response_code',
        'location_name',
        'regency',
        'province',
        'pic_name',
        'pic_phone',
        'total_devices',
        'total_antennas',
        'total_clients',
        'status',
        'ip_address',
        'user_agent',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'total_devices' => 'integer',
        'total_antennas' => 'integer',
        'total_clients' => 'integer',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function topology(): HasOne
    {
        return $this->hasOne(Topology::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class)->orderBy('sort_order', 'asc');
    }

    public function antennas(): HasMany
    {
        return $this->hasMany(Antenna::class)->orderBy('sort_order', 'asc');
    }

    public function uploads(): HasMany
    {
        return $this->hasMany(Upload::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(ResponseValue::class);
    }
}
