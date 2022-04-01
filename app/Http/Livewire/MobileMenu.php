<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Contact;
use App\Models\Kategori;
use Livewire\Component;

class MobileMenu extends Component
{
    public $qmobile;

    public function render()
    {
        $category = Kategori::all();
        $brands = Brand::all();
        $contacts = Contact::all();
        return view('livewire.mobile-menu',compact([
            'category',
            'brands',
            'contacts'
        ]));
    }

    public function search()
    {
        return redirect()->route('product')->with('qsearch',$this->qmobile);
    }
}
