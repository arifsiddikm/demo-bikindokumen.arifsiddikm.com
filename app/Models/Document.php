<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'template_used',
        'form_data', 'color_theme', 'status',
        'file_path', 'last_downloaded_at', 'download_count',
    ];

    protected $casts = [
        'form_data'           => 'array',
        'last_downloaded_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }
}
