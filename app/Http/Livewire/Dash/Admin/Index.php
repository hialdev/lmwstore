<?php

namespace App\Http\Livewire\Dash\Admin;

use App\Models\Email;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $count['pesanan'] = count(Pesanan::all());
        $count['costumers'] = count(User::role('user')->get());
        $count['products'] = count(Product::all());
        $count['category'] = count(Kategori::all());
        $pesanans = Pesanan::latest()->limit(7)->get();
        $mails = Email::latest()->limit(4)->get();
        return view('livewire.dash.admin.index',[
            'pesanans' => $pesanans,
            'count' => $count,
            'mails' => $mails,
        ])->extends('layouts.dashadmin')->section('body');
    }

    public function moreEmail()
    {
        redirect()->route('dash.email');
    }
}
