<?php

namespace App\Http\Livewire;

use App\Models\Value;
use Livewire\Component;

class IconBox extends Component
{
    public function render()
    {
        $values = Value::latest()->take(3)->get();
        return view('livewire.icon-box',compact('values'));
    }
}
