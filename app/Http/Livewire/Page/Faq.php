<?php

namespace App\Http\Livewire\Page;

use App\Models\Faq as ModelsFaq;
use Livewire\Component;

class Faq extends Component
{
    public function render()
    {
        $faqs = ModelsFaq::all();
        return view('livewire.page.faq',compact('faqs'));
    }
}
