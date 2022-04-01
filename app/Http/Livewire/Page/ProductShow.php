<?php

namespace App\Http\Livewire\Page;

use App\Helpers\Helper;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class ProductShow extends Component
{
    public $product,$next,$prev,$variant,$size,$qty = 1;
    public $wa,$name;
    public function mount($slug)
    {
        $this->product = Product::where('slug',$slug)->first();
        $this->next = Product::where('id', '<', $this->product->id)->orderBy('id','desc')->first();
        $this->prev = Product::where('id', '>', $this->product->id)->orderBy('id','asc')->first();;
    }
    public function render()
    {
        $this->seo();
        $products = Product::inRandomOrder()->limit(8)->get();
        return view('livewire.page.product-show',[
            'product' => $this->product,
            'next' => $this->next,
            'prev' => $this->prev,
            'products' => $products,
        ]);
    }
    public function seo()
    {
        SEOTools::setTitle($this->product->name);
        SEOTools::setDescription($this->product->brief);
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::twitter()->setSite($this->product->name);
        SEOTools::jsonLd()->addImage(json_decode($this->product->image)[0]);
    }
    public function addCart($id)
    {
        $this->validate([
            'variant' => 'required',
            'size' => 'required',
        ]);
        if (isset(Auth::user()->id)) {
            $uid = Auth::user()->id;
            $check = Cart::where('id_user',$uid)->where('id_product',$id)->first();
            if ($check == null) {
                $detail = [
                    'size' => $this->size,
                    'variant' => $this->variant,
                ];
                $cart = Cart::create(
                    [
                        "id_user" => $uid,
                        "id_product" => $id,
                        "qty" => $this->qty,
                        "detail" => json_encode($detail),
                    ] 
                );
        
                if ($cart) {
                    session()->flash('success','Sukses dimasukan ke keranjang!');
                }else{
                    session()->flash('failed','Gagal memasukan ke keranjang!');
                }   
            }else{
                $uid = $uid = Auth::user()->id;
                $detail = [
                    'size' => $this->size,
                    'variant' => $this->variant,
                ];
                $check = Cart::where('id_user',$uid)->where('id_product',$id)->where('detail',json_encode($detail))->first();
                //dd((json_decode($cart->detail)->size !== $this->size) || (json_decode($cart->detail)->variant !== $this->variant));
                if ($check) {
                    session()->flash('failed','Produk dengan variant dan size yang sama telah ada di kerajang!');
                }else{
                    $cart = Cart::create(
                        [
                            "id_user" => $uid,
                            "id_product" => $id,
                            "qty" => $this->qty,
                            "detail" => json_encode($detail),
                        ] 
                    );
            
                    if ($cart) {
                        session()->flash('success','Sukses dimasukan ke keranjang!');
                    }else{
                        session()->flash('failed','Gagal memasukan ke keranjang!');
                    } 
                }
            }

            $this->emit('updateCart');
        }else{
            redirect()->route('login');
        }
    }
    public function buyWA()
    {
        if (isset(Auth::user()->id)) {
            $name = Auth::user()->name; 
            $setting = Setting::all()->keyBy('key');
            $wa = $setting->get('wa_admin')->content;
            $this->wa = "https://wa.me/$wa?text=Hallo+LMW+Store%2C%0D%0ASaya+".$name."%2C+ingin+membeli+product+dengan+keterangan+sebagai+berikut%3A%0D%0A%0D%0AProduct+%3A+".$this->product->name."%0D%0AQty+%3A+".$this->qty."%0D%0AHarga+%3A+".Helper::rupiah($this->product->price-($this->product->price*$this->product->discount/100))."%0D%0AHarga+Asli+%3A+".Helper::rupiah($this->product->price)."%0D%0AVariant+%3A+".$this->variant."%0D%0ASize+%3A+".$this->size."%0D%0A%0D%0ATerimakasih.";

            redirect()->away($this->wa);
        }else{
            $this->wa = "https://wa.me/$wa?text=Hallo+LMW+Store%2C%0D%0ASaya+"."*Nama Anda*"."%2C+ingin+membeli+product+dengan+keterangan+sebagai+berikut%3A%0D%0A%0D%0AProduct+%3A+".$this->product->name."%0D%0AQty+%3A+".$this->qty."%0D%0AHarga+Promo+%3A+".Helper::rupiah($this->product->price-($this->product->price*$this->product->discount/100))."%0D%0AHarga+Asli+%3A+".Helper::rupiah($this->product->price)."%0D%0AVariant+%3A+".$this->variant."%0D%0ASize+%3A+".$this->size."%0D%0A%0D%0ATerimakasih.";
            redirect()->away($this->wa);
        }
    }
}
