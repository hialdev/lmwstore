<?php

namespace App\Http\Livewire\Dash\Admin\Product;

use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Label;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    public $images = [];
    public $ctg = [];
    public $label,$size,$variant,$desc,$name,$brief,$price,$discount,$stock,$brand,$po;
    public $updateMode = false;
    public $inputSize = [],$inputVariant = [];
    public $iSize = 1,$iVariant = 1;
    
    public function addSize($i)
    {
        $i = $i + 1;
        $this->iSize = $i;
        array_push($this->inputSize ,$i);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeSize($i)
    {
        unset($this->inputSize[$i]);
    }

    public function addVariant($i)
    {
        $i = $i + 1;
        $this->iVariant = $i;
        array_push($this->inputVariant ,$i);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeVariant($i)
    {
        unset($this->inputVariant[$i]);
    }

    public function render()
    {
        $brands = Brand::all();
        $labels = Label::all();
        $category = Kategori::all();
        return view('livewire.dash.admin.product.add',[
            'brands' => $brands,
            'labels' => $labels,
            'category' => $category,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function save()
    {
        $data = $this->validate([
            'size.0' => 'required',
            'variant.0' => 'required',
            'size.*' => 'required',
            'variant.*' => 'required',
            'images.*' => 'required|image',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'discount' => 'required|numeric',
            'brand' => 'required',
            'po' => 'required|numeric',
            'desc' => 'required',
            'brief' => 'required',
            'ctg' => 'required',
        ],
        [
            'size.0.required' => 'size field is required',
            'variant.0.required' => 'variant field is required',
            'size.*.required' => 'size field is required',
            'variant.*.required' => 'variant field is required',
        ]
        );

        $dataImage = [];
        $sizeData = [];
        $variantData = [];

        if (isset($this->images)) {
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/products/".$now;

            foreach ($this->size as $size) {
                $sizeData[] = $size;
            }
            $size = json_encode($sizeData);

            foreach ($this->variant as $variant) {
                $variantData[] = $variant;
            }
            $variant = json_encode($variantData);
            
            //Store and make dataimage
            foreach ($this->images as $key => $image) {
                $imageName = md5($this->images[$key].microtime().'.'.$image->extension());
                Storage::putFileAs(
                    'public'.$path,$this->images[$key],$imageName
                );
                $dataImage[] = $path.'/'.$imageName;
            }
            $img = json_encode($dataImage);
            
            $product = new Product();
            $product->id_brand = $this->brand;
            $product->name = $this->name;
            $product->id_label = $this->label;
            $product->image = $img;
            $product->brief = $this->brief;
            $product->price = $this->price;
            $product->discount = $this->discount;
            $product->desc = $this->desc;
            $product->stock = $this->stock;
            $product->preorder = $this->po;
            $product->size = $size;
            $product->variant = $variant;
            $product->slug = Str::slug($this->name);
            $product->save();

            foreach ($this->ctg as $ctg) {
                $product->categories()->attach($ctg);
            }

            $this->reset(['brand','name','brief','price','discount','desc','stock','po','size','variant']);
            session()->flash('success','Horaay... Berhasil menambahkan product.');
            redirect()->route('dash.product')->with('success','Horaay... Berhasil menambahkan product.');
        }else{
            session()->flash('failed','Ooops... Gagal menambahkan product.');
        }

    }
}
