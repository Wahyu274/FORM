<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topology extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'topology_type',
        'description',
        'notes',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }
}
