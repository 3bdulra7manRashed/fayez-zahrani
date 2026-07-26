<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_with_aggregated_statistics(): void
    {
        $user = User::factory()->create();

        Book::factory()->count(3)->create([
            'views_count' => 10,
            'downloads_count' => 5,
            'pages_count' => 100,
        ]);

        BookMessage::factory()->count(2)->create([
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee('لوحة التحليلات والإحصاءات')
            ->assertSee('30') // 3 books * 10 views
            ->assertSee('15'); // 3 books * 5 downloads
    }

    public function test_dashboard_displays_recent_books_and_messages(): void
    {
        $user = User::factory()->create();

        $book = Book::factory()->create(['title' => 'كتاب جديد مميز']);
        $message = BookMessage::factory()->create(['name' => 'مرسل جديد محترم']);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee('كتاب جديد مميز')
            ->assertSee('مرسل جديد محترم');
    }

    public function test_sidebar_displays_unread_messages_badge(): void
    {
        $user = User::factory()->create();

        BookMessage::factory()->count(5)->create(['is_read' => false]);
        BookMessage::factory()->count(2)->create(['is_read' => true]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('5');
    }
}
