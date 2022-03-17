<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Header extends Component
{

    public function render()
    {
        $categories = Kategori::all();
        $brands = Brand::all();
        return view('livewire.header',compact(['categories','brands']));
    }

}
