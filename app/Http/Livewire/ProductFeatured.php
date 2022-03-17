<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductFeatured extends Component
{
    public function render()
    {
        $products = Product::latest()->limit(6)->get();
        return view('livewire.product-featured',compact(['products']));
    }

    public function addCart($id)
    {
        if (isset(Auth::user()->id)) {
            $uid = Auth::user()->id;
            $check = Cart::where('id_user',$uid)->where('id_product',$id)->first();
            if ($check == null) {
                $cart = Cart::create(
                    [
                        "id_user" => $uid,
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
                $cart = Cart::where('id_user',$uid)->where('id_product',$id)->first();
                
                $cart->update(['qty'=>$cart->qty+1]);
                $cart->save();

                if ($cart) {
                    session()->flash('success','Sukses ditambahkan ke keranjang!');
                }
            }

            $this->emit('updateCart');
        }else{
            redirect()->route('login');
        }
    }
}
