<?php

namespace App\Http\Livewire\Page;

use App\Models\Coupon;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderClear extends Component
{
    public $selected;

    public function boot()
    {
        $pesanan = Pesanan::where('id_user',Auth::id())->where('status',1)->latest()->first();
        if (isset($pesanan)) {
            $selected = Pesanan::findOrFail($pesanan->id);
            $this->selected = $selected;
        }else{
            $this->selected = null;
        }
    }

    public function render()
    {
        $pesanan = Pesanan::where('id_user',Auth::id())->where('status',1)->latest()->get();
        if (isset($this->selected)) {
            $pesananDetail = PesananDetail::where('id_pesanan',$this->selected->id)->get();
            $coupon = Coupon::where('code',$this->selected->coupon)->first();
        }else{
            $pesananDetail = null;
            $coupon = null;
        }
        return view('livewire.page.order-clear',[
                'pesanan' => $pesanan,
                'selected' => $this->selected,
                'details' => $pesananDetail,
                'coupon' => $coupon,
            ])
            ->extends('layouts.dashuser')
            ->section('body');
    }

    public function detailPesanan($id)
    {
        $selected = Pesanan::findOrFail($id);
        $this->selected = $selected;
    }
}
