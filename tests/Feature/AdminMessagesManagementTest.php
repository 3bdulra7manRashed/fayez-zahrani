<?php

namespace Tests\Feature;

use App\Livewire\Admin\Messages\Index;
use App\Models\BookMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminMessagesManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_messages_index_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertStatus(200)
            ->assertSee('الرسائل الواردة');
    }

    public function test_admin_can_filter_unread_messages(): void
    {
        $user = User::factory()->create();

        $unread = BookMessage::factory()->create([
            'name' => 'مرسل غير مقروء',
            'is_read' => false,
        ]);

        $read = BookMessage::factory()->create([
            'name' => 'مرسل مقروء',
            'is_read' => true,
        ]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('setFilter', 'unread')
            ->assertSee('مرسل غير مقروء')
            ->assertDontSee('مرسل مقروء');
    }

    public function test_opening_message_marks_it_as_read(): void
    {
        $user = User::factory()->create();

        $message = BookMessage::factory()->create([
            'is_read' => false,
        ]);

        $this->assertFalse($message->is_read);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('openMessage', $message->id)
            ->assertSet('showModal', true);

        $this->assertTrue($message->fresh()->is_read);
    }

    public function test_admin_can_delete_a_message(): void
    {
        $user = User::factory()->create();

        $message = BookMessage::factory()->create();

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('confirmDelete', $message->id)
            ->call('delete')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('book_messages', [
            'id' => $message->id,
        ]);
    }
}
