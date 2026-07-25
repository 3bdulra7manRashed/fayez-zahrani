<?php

namespace App\Livewire\Admin\Messages;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('الرسائل الواردة - لوحة التحكم')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.messages.index');
    }
}
