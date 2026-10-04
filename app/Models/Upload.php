<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'field_name',
        'category',
        'original_name',
        'filename',
        'filepath',
        'mime_type',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }

    public function getUrlAttribute(): string
    {
        $cleanPath = ltrim($this->filepath, '/');
        // Use relative asset URL to work on any domain / host / protocol
        return asset('storage/' . $cleanPath);
    }

    public function getBase64SrcAttribute(): ?string
    {
        $cleanPath = ltrim($this->filepath, '/');
        $possiblePaths = [
            storage_path('app/public/' . $cleanPath),
            public_path('storage/' . $cleanPath),
            base_path('storage/app/public/' . $cleanPath),
        ];

        foreach ($possiblePaths as $p) {
            if (file_exists($p) && is_file($p)) {
                $content = @file_get_contents($p);
                if ($content !== false) {
                    $mime = $this->mime_type ?: (@mime_content_type($p) ?: 'image/jpeg');
                    return 'data:' . $mime . ';base64,' . base64_encode($content);
                }
            }
        }

        return null;
    }

    public function isImage(): bool
    {
        if (!empty($this->mime_type) && str_starts_with($this->mime_type, 'image/')) {
            return true;
        }

        $candidates = [$this->filename, $this->filepath, $this->original_name];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg'];
        foreach ($candidates as $name) {
            if (!empty($name)) {
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (in_array($ext, $imageExtensions)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }
}
