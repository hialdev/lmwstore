<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Livewire\Component;

class Hero extends Component
{
    public function render()
    {
        $banners = Banner::where('featured',1)->take(2)->get();
        if (count($banners) <= 0 || count($banners) === null) {
            $banners = Banner::latest()->get();
        }else{
            $moreBanners = Banner::where('featured',0)->latest()->take(3)->get();
            $banners = $banners->merge($moreBanners);
        }

        return view('livewire.hero',compact('banners'));
    }
}
