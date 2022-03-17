<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomeIndex extends Component
{

    public $userid,$brand = null, $qcoupon;
    protected $rules = [
        'coupon' => 'regex:/^\S*$/u',
    ];
    public function render()
    {
        $this->userid = Auth::user()->id;
        $products = $this->brand !== null ? Product::where('id_brand',$this->brand)->latest()->get() : Product::latest()->get() ;
        $brands = Brand::all();
        $carts = Cart::where('id_user',Auth::user()->id)->get();
        $total = Cart::where('id_user', Auth::user()->id)
                ->join('products', 'products.id', '=', 'carts.id_product')
                ->sum(DB::raw('products.price * carts.qty'));
        $coupon = $this->couponDisc()!== null?$this->couponDisc():null;
        $total_disc = $coupon ? $total*$coupon->disc:null;
        if ($coupon) {
            if ($total_disc >= $coupon->max) {
                $total_disc = $coupon->max;
            }
        }
        $disc = $total_disc ? $total - $total_disc : $total;
        $ppn = $disc*10/100;
        $total_seluruh = $total+$ppn-$total_disc;
        
        return view('livewire.home-index',[
            "brands" => $brands,
            "products" => $products,
            'carts' => $carts,
            'total' => $total,
            'ppn' => $ppn,
            'total_disc' => $total_disc,
            'total_seluruh' => $total_seluruh,
            'coupon' => $coupon,
        ]);
    }

    public function addCart($id)
    {
        $check = Cart::where('id_user',$this->userid)->where('id_product',$id)->first();
        if ($check == null) {
            $cart = Cart::create(
                [
                    "id_user" => $this->userid,
                    "id_product" => $id,
                    "qty" => 1,
                ] 
            );
    
            if ($cart) {
                session()->flash('success','Sukses dimasukan ke keranjang!');
            }else{
                session()->flash('failed','Gagal memasukan ke keranjang!');
            }   
        }else{
            $cart = Cart::where('id_user',$this->userid)->where('id_product',$id)->first();
            
            $cart->update(['qty'=>$cart->qty+1]);
            $cart->save();

            if ($cart) {
                session()->flash('success','Sukses ditambahkan ke keranjang!');
            }
        }

        $this->emit('updateCart');
    }

    public function filterBrand($id)
    {
        $this->brand = $id;
    }

    public function delCart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        if ($cart) {
            session()->flash('success','Berhasil menghapus data '.$cart->product->name. ' dari keranjang.');
        }

        $this->emit('updateCart');
    }

    public function couponDisc()
    {
        $coupon = Coupon::where('code','=',$this->qcoupon)->first();

        if ($coupon) {
            $coupon = $coupon;
        }else{
            $coupon = null;
        }
        return $coupon;
    }
}
