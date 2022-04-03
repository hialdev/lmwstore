<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Product;
use Livewire\Component;
use Spatie\Sitemap\Sitemap as SitemapSpatie;
use Spatie\Sitemap\Tags\Url;

class Sitemap extends Component
{
    public $s;
    public function mount()
    {
        $sitemap = SitemapSpatie::create()
        ->add(Url::create('/home'))
        ->add(Url::create('/product'))
        ->add(Url::create('/contact'))
        ->add(Url::create('/faq'))
        ->add(Url::create('/cart'))
        ->add(Url::create('/login'))
        ->add(Url::create('/register'))
        ->add(Url::create('/transaksi-pending'))
        ->add(Url::create('/transaksi-sukses'))
        ->add(Url::create('/profile'));

        $products = Product::all();
        foreach ($products as $product) {
            $sitemap->add(Url::create("/product/{$product->slug}"));
        }

        $brands = Brand::all();
        foreach ($brands as $brand) {
            $sitemap->add(Url::create("/brand/{$brand->slug}"));
        }

        $category = Kategori::all();
        foreach ($category as $ctg) {
            $sitemap->add(Url::create("/category/{$ctg->slug}"));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        if ($sitemap) {
            $this->s = 1;
        }else{
            $this->s = 0;
        }
    }

    public function render()
    {
        return view('livewire.sitemap',[
            's' => $this->s,
        ]);
    }
}
