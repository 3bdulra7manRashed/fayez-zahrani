<?php

namespace App\Livewire\Admin\Messages;

use App\Models\BookMessage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('الرسائل الواردة - لوحة التحكم')]
class Index extends Component
{
    use WithPagination;

    public string $filter = 'all'; // 'all', 'unread', 'read'
    public string $search = '';

    public ?BookMessage $selectedMessage = null;
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $deletingMessageId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        if (in_array($filter, ['all', 'unread', 'read'])) {
            $this->filter = $filter;
            $this->resetPage();
        }
    }

    public function openMessage(int $id): void
    {
        $message = BookMessage::with('book')->findOrFail($id);

        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        $this->selectedMessage = $message;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedMessage = null;
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingMessageId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingMessageId = null;
    }

    public function delete(): void
    {
        if (!$this->deletingMessageId) {
            return;
        }

        $message = BookMessage::findOrFail($this->deletingMessageId);

        if ($this->selectedMessage && $this->selectedMessage->id === $message->id) {
            $this->closeModal();
        }

        $message->delete();

        session()->flash('message', 'تم حذف الرسالة بنجاح.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $messages = BookMessage::with('book')
            ->when($this->filter === 'unread', fn ($q) => $q->where('is_read', false))
            ->when($this->filter === 'read', fn ($q) => $q->where('is_read', true))
            ->when(trim($this->search) !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . trim($this->search) . '%')
                      ->orWhere('email', 'like', '%' . trim($this->search) . '%')
                      ->orWhere('message', 'like', '%' . trim($this->search) . '%')
                      ->orWhereHas('book', fn ($bq) => $bq->where('title', 'like', '%' . trim($this->search) . '%'));
                });
            })
            ->latest()
            ->paginate(10);

        $unreadCount = BookMessage::where('is_read', false)->count();
        $totalCount = BookMessage::count();
        $readCount = BookMessage::where('is_read', true)->count();

        return view('livewire.admin.messages.index', [
            'messages' => $messages,
            'unreadCount' => $unreadCount,
            'totalCount' => $totalCount,
            'readCount' => $readCount,
        ]);
    }
}
