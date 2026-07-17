<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'edition',
        'pages_count',
        'dimensions',
        'publisher',
        'published_at',
        'cover_path',
        'pdf_path',
        'views_count',
        'downloads_count',
    ];

    protected $casts = [
        'published_at' => 'date',
        'pages_count' => 'integer',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
    ];

    /**
     * Get the messages sent to the author for this book.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(BookMessage::class);
    }
}
