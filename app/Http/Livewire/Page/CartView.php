<?php

namespace App\Http\Livewire\Page;

use App\Models\Cart;
use App\Models\Coupon;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartView extends Component
{

    public $coupon,$cpn_sale;
    public $listeners = [
        'refreshCart' => '$refresh',
    ];
    public function boot()
    {
        session()->forget('coupon');
        session()->save();
    }
    public function render()
    {
        $this->seo();
        $data = $this->cartData();
        $cpn = Coupon::where('code',$this->coupon)->first();
        if ($cpn !== null && $this->cpn_sale > $cpn->max) {
            $sum_cpn = $data['total']-$cpn->max;
        }else{
            $sum_cpn = $data['total']-$this->cpn_sale;
        }
        return view('livewire.page.cart-view',[
            'cart' => $data,
            'total' => $data['total'],
            'cpnData' => $cpn,
            'cpn' => $this->cpn_sale,
            'calc' => $sum_cpn,
        ]);
    }
    public function seo()
    {
        $uid = Auth::id();
        $cart = Cart::where('id_user',$uid)->latest()->first();

        SEOTools::setTitle('View Cart - LMW Store');
        SEOTools::setDescription('Kelola produk pada keranjang anda.');
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'pages');
        SEOTools::twitter()->setSite('View Cart - LMW Store');
        SEOTools::jsonLd()->addImage(isset($cart->product) ? json_decode($cart->product->image)[0] : '/assets/images/lmw-logo.png');
    }
    //Mengambil data keranjang
    public function cartData()
    {
        $uid = Auth::id();
        $carts = Cart::where('id_user',$uid)->latest()->get();
        //$cart = Cart::where('id_user',$uid)->latest()->limit(3)->get();
        
        $total = 0;
        foreach ($carts as $cart) {
            $total += ($cart->product->price - $cart->product->price*$cart->product->discount/100)*$cart->qty; 
        }

        $cartData = [
            'data' => $carts,
            'count' => count($carts),
            'total' => $total,
        ];
        return $cartData;
    }
    //Hapus item cart
    public function delCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        if ($cart) {
            session()->flash('success','Berhasil menghapus '.$cart->product->name.' dari keranjang');
        }
        $this->emit('updateCart');
    }
    //tambah qty
    public function addQty($id)
    {
        $cart = Cart::find($id);
        $cart->update(['qty'=>$cart->qty+1]);

        $this->emit('updateCart');
    }
    //Kurangi qty
    public function delQty($id)
    {
        $cart = Cart::find($id);
        if ($cart->qty <= 1) {
            session()->flash('failed','Minimal ada 1 qty dikeranjang.');
        }else{
            $cart->update(['qty'=>$cart->qty-1]);
        }

        $this->emit('updateCart');
        
    }

    //Kelola Coupon Form
    public function coupon()
    {
        $cpn = Coupon::where('code',$this->coupon)->first();
        $data = $this->cartData();
        if ($cpn) {
            Session::put('coupon', $this->coupon);
            $coupon = $data['total']*$cpn->discount/100;
            if ($coupon > $cpn->max) {
                $coupon = $cpn->max;
            }
        }else{
            $coupon = 0;
        }
        $this->cpn_sale = $coupon;
    }
}
