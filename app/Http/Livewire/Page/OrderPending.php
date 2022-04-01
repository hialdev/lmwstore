<?php

namespace App\Http\Livewire\Page;

use App\Models\Bank;
use App\Models\Coupon;
use App\Models\Page;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class OrderPending extends Component
{
    public $selected;

    public function boot()
    {
        $this->seo();
        $pesanan = Pesanan::where('id_user',Auth::id())->where('status',0)->latest()->first();
        if (isset($pesanan)) {
            $selected = Pesanan::findOrFail($pesanan->id);
            $this->selected = $selected;
        }else{
            $this->selected = null;
        }
    }

    public function seo()
    {
        $seo = Page::all()->keyBy('name');
        $s_index = $seo->get('order-pending')->meta;
        SEOTools::setTitle($s_index->title);
        SEOTools::setDescription($s_index->desc);
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', $s_index->type);
        SEOTools::twitter()->setSite($s_index->title);
        SEOTools::jsonLd()->addImage(asset('storage'.$s_index->image));
    }

    public function render()
    {
        $pesanan = Pesanan::where('id_user',Auth::id())->where('status',0)->latest()->get();
        if (isset($this->selected)) {
            $pesananDetail = PesananDetail::where('id_pesanan',$this->selected->id)->get();
            $coupon = Coupon::where('code',$this->selected->coupon)->first();
        }else{
            $pesananDetail = null;
            $coupon = null;
        }
        $banks = Bank::all();
        return view('livewire.page.order-pending',[
                'pesanan' => $pesanan,
                'selected' => $this->selected,
                'details' => $pesananDetail,
                'coupon' => $coupon,
                'banks' => $banks,
            ])
            ->extends('layouts.dashuser')
            ->section('body');
    }

    public function detailPesanan($id)
    {
        $selected = Pesanan::findOrFail($id);
        $this->selected = $selected;
    }

    public function delPesanan($id)
    {
        Pesanan::findOrFail($id)->delete();
        redirect()->route('order.pending');
    }

    public function confirm($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $inv = $pesanan->kode_pesanan;
        $name = Auth::user()->name;
        $setting = Setting::all()->keyBy('key');
        $wa = $setting->get('wa_admin')->content;
        $wa = "https://wa.me/$wa?text=Hallo+LMW+Store%2C%0D%0ASaya+".$name."%2C+ingin+mengkonfirmasi+pesanan.%0AInvoice:+".$inv;
        redirect()->away($wa);
    }
}
