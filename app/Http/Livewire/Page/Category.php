<?php

namespace App\Http\Livewire\Page;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Category extends Component
{
    public $ctg,$slug,$sortby,$q,$products,$count,$limit = 999;
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->ctg = Kategori::where('slug',$slug)->first();
        $this->sortby = "termahal";
        $this->products = $this->getProducts();
        $this->count = count($this->products);

    }
    
    public function render()
    {
        //$products = Kategori::with('products')->orderBy('price','desc')->get();
        $this->products = $this->getProducts();
        $brands = Brand::all();
        $slug = $this->slug;
        $this->seo();

        return view('livewire.page.category',[
            'products' => $this->products,
            'limit' => $this->limit,
            'count' => $this->count,
            'brands' => $brands,
            'name' => $slug,
            'idbrand' => null,
        ]);
    }
    public function seo()
    {
        SEOTools::setTitle('Category - '.$this->ctg->name);
        SEOTools::setDescription('LMW Store mencari product dengan kategori '.$this->ctg->name);
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'category');
        SEOTools::twitter()->setSite('Category - '.$this->ctg->name);
    }
    public function getProducts()
    {   

        $slug = $this->slug;
        if (strlen($this->q > 0)) {
            $prod = Product::whereHas('categories', function($q) use($slug) {
            
                if ($this->sortby === "terbaru") {
                    $q->where('slug', $slug)->where('products.name','like','%'.$this->q.'%')->orderBy('products.created_at','desc')->limit($this->limit);
                }elseif ($this->sortby === "termahal") {
                    $q->where('slug', $slug)->where('products.name','like','%'.$this->q.'%')->orderBy('products.price','desc')->limit($this->limit);
                } elseif ($this->sortby === "termurah") {
                    $q->where('slug', $slug)->where('products.name','like','%'.$this->q.'%')->orderBy('products.price','asc')->limit($this->limit);
                }else{
                    $q->where('slug', $slug)->where('products.name','like','%'.$this->q.'%')->orderBy('products.discount','desc')->limit($this->limit);
                }
            })->get();
        }else{
            $prod = Product::whereHas('categories', function($q) use($slug) {
                if ($this->sortby === "terbaru") {
                    $q->where('slug', $slug)->orderBy('products.created_at','desc')->limit($this->limit);
                }elseif ($this->sortby === "termahal") {
                    $q->where('slug', $slug)->orderBy('products.price','desc')->limit($this->limit);
                } elseif ($this->sortby === "termurah") {
                    $q->where('slug', $slug)->orderBy('products.price','asc')->limit($this->limit);
                }else{
                    $q->where('slug', $slug)->orderBy('products.discount','desc')->limit($this->limit);
                }
            })->get();
        }
        
        $data=$prod;
        return $data;
    }

    public function more()
    {
        $this->limit = $this->limit+12;
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
