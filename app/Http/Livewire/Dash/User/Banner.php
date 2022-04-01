<?php

namespace App\Http\Livewire\Dash\User;

use App\Models\BannerCustom;
use Livewire\Component;

class Banner extends Component
{
    public function render()
    {
        $banner = BannerCustom::first();
        return view('livewire.dash.user.banner',compact('banner'));
    }
}
