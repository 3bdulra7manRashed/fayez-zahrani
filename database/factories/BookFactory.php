<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'description' => fake()->paragraph(),
            'edition' => 'الطبعة الأولى',
            'publisher' => 'دار النشر',
            'published_at' => fake()->date(),
            'pages_count' => fake()->numberBetween(50, 500),
            'dimensions' => '17x24 سم',
            'cover_path' => 'books/cover_' . fake()->uuid() . '.jpg',
            'pdf_path' => 'books/pdf_' . fake()->uuid() . '.pdf',
            'views_count' => fake()->numberBetween(0, 500),
            'downloads_count' => fake()->numberBetween(0, 100),
        ];
    }
}
