<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Livewire\Component;

class Invoice extends Component
{
    public function render()
    {
        $cpn = $this->coupon();
        $pesanan = Pesanan::where('kode_pesanan',session()->get('kode_pesanan'))->first();
        $pesanan_detail = PesananDetail::where('id_pesanan',$pesanan->id)->get();
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        return view('livewire.invoice',[
            'pesanan' => $pesanan,
            'pdtl' => $pesanan_detail,
            'coupon' => $cpn['coupon'],
            'total' => $cpn['total'],
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

    public function confirm()
    {
        
    }
}
