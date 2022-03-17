<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CartIndex extends Component
{

    protected $listeners = [
        'updateCart' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.cart-index',[
            "cart" => $this->dataCart(),
        ]);

    }

    public function dataCart()
    {
        $userid = Auth::user()->id;
        $carts = Cart::where('id_user','=',$userid)->latest()->get();
        $count = count($carts);
        $total = Cart::where('id_user', Auth::user()->id)
                ->join('products', 'products.id', '=', 'carts.id_product')
                ->sum(DB::raw('products.price * carts.qty'));
        
        $cartData = [
            "data" => $carts,
            "total" => $total,
            "count" => $count,
        ];

        return $cartData;
    }

}
