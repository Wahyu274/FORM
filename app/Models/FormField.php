<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'section_id',
        'label',
        'name',
        'type',
        'is_required',
        'is_active',
        'sort_order',
        'placeholder',
        'help_text',
        'default_value',
        'validation_rules',
        'options',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'validation_rules' => 'array',
        'options' => 'array',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }

    public function optionItems(): HasMany
    {
        return $this->hasMany(FormFieldOption::class, 'field_id')->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
