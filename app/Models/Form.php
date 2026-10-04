<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'code_prefix',
        'description',
        'is_active',
        'max_clients_per_antenna',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'max_clients_per_antenna' => 'integer',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(FormSection::class)->orderBy('sort_order', 'asc');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order', 'asc');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
