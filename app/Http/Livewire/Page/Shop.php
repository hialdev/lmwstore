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

class Shop extends Component
{
    public $brand,$sortby,$q,$limit = 12;

    public function render()
    {
        if (session()->has('qsearch')) {
            $this->q = session()->get('qsearch');
        }
        $this->seo();
        $data = $this->getProducts();
        $products = $data['products'];
        $count = $data['count'];
        $brands = Brand::all();

        return view('livewire.page.shop',[
            'products' => $products,
            'limit' => $this->limit,
            'count' => $count,
            'brands' => $brands,
            'idbrand' => $this->brand,
        ]);
    }

    public function seo()
    {
        SEOTools::setTitle('List Products - LMW Store');
        SEOTools::setDescription('Product LMW dengan brand ELEMWE dan Batik Betawi Tambora');
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'pages');
        SEOTools::twitter()->setSite('LMW Store - List Products');
        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');
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
            $products = $products->where('name','like','%'.$this->q.'%')->orWhere('brief','like','%'.$this->q.'%')->get();
            $prd = Product::where('name','like','%'.$this->q.'%')->orWhere('brief','like','%'.$this->q.'%')->get();
            $count = count($prd);
        }else{
            $prd = Product::all();
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

    public function brand($id)
    {
        if ($this->model === "brand") {
            
        }else{
            if ($id === 0) {
                $this->brand = null;
            }else{
                $this->brand = $id;
            }
        }
    }

}
