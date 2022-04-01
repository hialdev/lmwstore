<?php

namespace App\Http\Livewire;

use App\Models\BannerCustom;
use Livewire\Component;

class CustomBanner extends Component
{
    public function render()
    {
        $banner =  BannerCustom::first();
        return view('livewire.custom-banner',compact('banner'));
    }
}
