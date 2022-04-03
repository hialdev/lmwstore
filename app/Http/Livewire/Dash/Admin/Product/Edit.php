<?php

namespace App\Http\Livewire\Dash\Admin\Product;

use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Label;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $imageData = [],$images = [], $imgd = [];
    public $ctg = [];
    public $product;
    public $label,$size,$variant,$desc,$name,$brief,$price,$discount,$stock,$brand,$po;
    public $updateMode = false;
    public $inputSize = [],$inputVariant = [];
    public $iSize,$iVariant;
    
    public function mount($id)
    {
        $product = Product::findOrFail($id);
        $this->brand = $product->id_brand;
        $this->name = $product->name;
        $this->label = $product->id_label;
        $this->imageData = json_decode($product->image);
        $this->brief = $product->brief;
        $this->price = $product->price;
        $this->discount = $product->discount;
        $this->desc = $product->desc;
        $this->stock = $product->stock;
        $this->po = $product->preorder;
        $this->size = json_decode($product->size);
        $this->variant = json_decode($product->variant);
        $this->ctg = $product->categories()->get()->pluck('id')->toArray();
        $this->product = $product;
        
        $this->imgd = json_decode($product->image);
        $this->inputSize = json_decode($product->size);
        $this->inputVariant = json_decode($product->variant);
        $this->iSize = count($this->size);
        $this->iVariant = count($this->variant);
    }

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
        unset($this->size[$i]);
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
        unset($this->variant[$i]);
    }
    
    public function render()
    {
        $brands = Brand::all();
        $labels = Label::all();
        $category = Kategori::all();

        return view('livewire.dash.admin.product.edit',[
            'brands' => $brands,
            'labels' => $labels,
            'category' => $category,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function delImage($img)
    {
        if (count(json_decode($this->product->image)) > 2) {
            $path = $img;
            $images = json_decode($this->product->image);
            $dataImg = [];
            foreach ($images as $key => $value) {
                if ($img === $value) {
                    unset($images[$key]);
                }
            }
            foreach ($images as $value) {
                $dataImg[] = $value;
            }
            $this->imgd = $dataImg;
            if(File::exists('storage'.$path)){
                $this->product->update(['image' => json_encode($this->imgd)]);
                File::delete('storage'.$path);
                $this->imageData = $this->imgd;
                session()->flash('success','Berhasil menghapus gambar.');
            }else{
                session()->flash('failed','File tersebut sudah tidak ada. silahkan refresh halaman.');
            }
        } else {
            session()->flash('failed','Gagal menghapus, minimal ada 2 gambar per produk.');
        }

    }

    public function update()
    {
        $data = $this->validate([
            'size.0' => 'required',
            'variant.0' => 'required',
            'size.*' => 'required',
            'variant.*' => 'required',
            'images.*' => 'nullable|image',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'discount' => 'required|numeric',
            'brand' => 'required',
            'po' => 'required|numeric',
            'desc' => 'required',
            'brief' => 'required',
            'ctg' => 'required',
            'label' => 'required|numeric',
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
                $imageName = md5($this->images[$key].microtime()).'.'.$image->extension();
                Storage::putFileAs(
                    'public'.$path,$this->images[$key],$imageName
                );
                $dataImage[] = $path.'/'.$imageName;
            }
            $img = array_merge($this->imgd,$dataImage);
            $img = json_encode($img);
            $this->product->update([
                'id_brand' => $this->brand,
                'id_label' => $this->label,
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'discount' => $this->discount,
                'preorder' => $this->po,
                'desc' => $this->desc,
                'brief' => $this->brief,
                'size' => $size,
                'variant' => $variant,
                'image' => $img,
                'slug' => Str::slug($this->name),
            ]);

            //Update Categories
            $this->product->categories()->detach();
            foreach ($this->ctg as $ctg) {
                $this->product->categories()->attach($ctg);
            }

            session()->flash('success','Horaay... Berhasil update product.');
            redirect()->route('dash.product')->with('success','Horaay... Berhasil update product.');
        }else{
            session()->flash('failed','Ooops... Gagal menambahkan product.');
        }
    }
}
