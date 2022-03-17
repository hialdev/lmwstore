<?php

namespace App\Http\Livewire\Dash\Admin;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $pesanans = Pesanan::latest()->limit(7)->get();
        return view('livewire.dash.admin.index',[
            'pesanans' => $pesanans,
        ])->extends('layouts.dashadmin')->section('body');
    }
}
