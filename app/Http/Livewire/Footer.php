<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\FooterLink;
use App\Models\FooterSection;
use App\Models\Setting;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        $contacts = Contact::all();
        $footers = FooterSection::limit(2)->get();
        $setting = Setting::all()->keyBy('key');
        return view('livewire.footer',compact('footers','contacts','setting'));
    }
}
