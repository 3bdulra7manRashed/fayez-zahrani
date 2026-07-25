<?php

namespace App\Livewire\Admin\Books;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('إدارة الكتب - لوحة التحكم')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.books.index');
    }
}
