<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookMessage>
 */
class BookMessageFactory extends Factory
{
    protected $model = BookMessage::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'is_read' => false,
        ];
    }
}
