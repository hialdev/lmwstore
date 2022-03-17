<?php

namespace App\Http\Livewire\Page;

use App\Models\Brand as ModelsBrand;
use App\Models\Cart;
use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Brand extends Component
{
    public $brand,$sortby,$q,$limit = 12;

    public function mount($slug)
    {
        $brand = ModelsBrand::where('slug',$slug)->first();
        $this->brand = $brand->id;
    }

    public function render()
    {
        $data = $this->getProducts();
        $products = $data['products'];
        $count = $data['count'];
        $brand = ModelsBrand::findOrFail($this->brand);
        $brands = ModelsBrand::all();
        $this->seo();
        return view('livewire.page.brand',[
            'products' => $products,
            'limit' => $this->limit,
            'count' => $count,
            'name' => $brand->name,
            'brands' => $brands,
            'idbrand' => $this->brand,
        ]);
    }

    public function seo()
    {
        $brand = ModelsBrand::findOrFail($this->brand);
        SEOTools::setTitle('Brand - '.$brand->name);
        SEOTools::setDescription('LMW Store mencari product dengan brand '.$brand->name);
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'brand');
        SEOTools::twitter()->setSite('Brand - '.$brand->name);
        SEOTools::jsonLd()->addImage($brand->image);
    }

    public function getProducts()
    {
        if ($this->sortby === "terbaru") {
            $products = Product::latest()->limit($this->limit);
        }elseif ($this->sortby === "termahal") {
            $products = Product::orderBy('price','desc')->limit($this->limit);
        } elseif ($this->sortby === "termurah") {
            $products = Product::orderBy('price','asc')->limit($this->limit);
        }else{
            $products = Product::orderBy('discount','desc')->limit($this->limit);
        }

        if (strlen($this->q) > 0) {
            $products = $products->where('id_brand',$this->brand)->where('name','like','%'.$this->q.'%')->orWhere('brief','like','%'.$this->q.'%')->get();
            $prd = Product::where('name','like','%'.$this->q.'%')->where('id_brand',$this->brand)->orWhere('brief','like','%'.$this->q.'%')->get();
            $count = count($prd);
        }else{
            $prd = Product::where('id_brand',$this->brand)->orWhere('brief','like','%'.$this->q.'%')->get();
            $products = $products->get();
            $count = count($prd);
        }
        $data=['products' => $products,'count'=>$count];
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