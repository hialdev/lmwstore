<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartLog extends Component
{
    protected $listeners = [
        'updateCart' => '$refresh',
    ];

    public $q;
    
    public function render()
    {
        if (isset(Auth::user()->id)) {
            $user = User::findOrFail(Auth::user()->id);
        }else{
            $user = null;
        }
        $carts = $this->cartData();
        $ppndng = Pesanan::where('status',0)->where('id_user',Auth::id())->get();
        
        return view('livewire.cart-log',compact(['carts','user','ppndng']));
    }

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

    public function delCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        if ($cart) {
            session()->flash('success','Berhasil menghapus '.$cart->product->name.' dari keranjang');
        }

        $this->emit('refreshCart');
    }

    public function addQty($id)
    {
        $cart = Cart::find($id);
        $cart->update(['qty'=>$cart->qty+1]);

        $this->emit('updateCart');
    }

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

    public function logout()
    {
        Session::flush();
        Auth::logout();
        redirect()->route('login');
    }

    public function search()
    {
        return redirect()->route('product')->with('qsearch',$this->q);
    }
}
