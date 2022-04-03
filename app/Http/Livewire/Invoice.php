<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Coupon;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Invoice extends Component
{
    public function boot()
    {
        $p = Pesanan::where('kode_pesanan',session()->get('kode_pesanan'))->first();
        if ( Auth::id() === null || $p->details === null) {
            redirect()->route('product');
        }
        SEOTools::setTitle('Invoice - '.session()->get('kode_pesanan'));
        SEOTools::setDescription('Transaksi dengan Invoice '.session()->get('kode_pesanan'));
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'page');
        SEOTools::twitter()->setSite('Invoice - '.session()->get('kode_pesanan'));
        SEOTools::jsonLd()->addImage(asset('storage'.json_decode($p->details[0]->product->image)[0]));
    }

    public function render()
    {
        $cpn = $this->coupon();
        $pesanan = Pesanan::where('kode_pesanan',session()->get('kode_pesanan'))->first();
        $pesanan_detail = PesananDetail::where('id_pesanan',$pesanan->id)->get();
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        $banks = Bank::all();
        return view('livewire.invoice',[
            'pesanan' => $pesanan,
            'pdtl' => $pesanan_detail,
            'coupon' => $cpn['coupon'],
            'total' => $cpn['total'],
            'banks' => $banks,
        ]);
    }

    public function coupon()
    {
        $psnn = Pesanan::where('kode_pesanan',session()->get('kode_pesanan'))->first();
        $cpn = Coupon::where('code',$psnn->coupon)->first();
        $pesanan_detail = PesananDetail::where('id_pesanan',$psnn->id)->get();
        
        $total = 0;
        foreach ($pesanan_detail as $p) {
            $total += ($p->product->price - $p->product->price*$p->product->discount/100)*$p->qty;
        }
        
        if ($cpn) {
            $coupon = $total*$cpn->discount/100;
            if ($coupon > $cpn->max) {
                $coupon = $cpn->max;
            }
        }else{
            $coupon = 0;
        }

        $data = [
            'coupon' => $coupon,
            'total' => $total,
        ];
        return $data;
    }

    public function confirm($id)
    {
        $name = Auth::user()->name;
        $pesanan = Pesanan::findOrFail($id);
        $inv = $pesanan->kode_pesanan;
        $setting = Setting::all()->keyBy('key');
        $wa = $setting->get('wa_admin')->content;
        $wa = "https://wa.me/$wa?text=Hallo+LMW+Store%2C%0D%0ASaya+".$name."%2C+ingin+mengkonfirmasi+pesanan.%0AInvoice:+".$inv;
        redirect()->away($wa);
    }
}
