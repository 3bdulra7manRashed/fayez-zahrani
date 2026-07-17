<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'name',
        'email',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the book this message is about.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
