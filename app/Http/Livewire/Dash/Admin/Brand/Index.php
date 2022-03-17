<?php

namespace App\Http\Livewire\Dash\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $name,$image,$imgedit;
    public $check = [],$selected = [];
    protected $brands;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $brands = Brand::where('name','like','%'.$this->q.'%')->latest();
        }else{
            $brands = Brand::latest();
        }

        $this->brands = $brands->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.brand.index',[
            'brands' => $this->brands,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'name' => 'required|string',
            'image' => 'required|image'
        ]);
        
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $path = "/media/images/brands/".$now;
        $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
        Storage::putFileAs(
            'public'.$path,$data['image'],$imageName
        );
        $img = $path.'/'.$imageName;

        $brand = new Brand();
        $brand->name = $data['name'];
        $brand->image = $img;
        $brand->slug = Str::slug($data['name']);
        $brand->save();

        if ($brand) {
            $this->reset(['name','image']);
            session()->flash('success','Berhasil menambahkan Brand '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['name','image','selectId']);
    }

    public function edit($id)
    {
        $this->image = null;
        $this->editModal = true;
        $brand = Brand::findOrFail($id);
        $this->name = $brand->name;
        $this->imgedit = $brand->image;
        $this->selectId = $brand->id;
    }

    public function update($id)
    {
        $data = $this->validate([
            'name' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        $brand = Brand::findOrFail($id);

        if ($data['image']) {
            if(File::exists('storage'.$this->imgedit)){
                File::delete('storage'.$this->imgedit);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/brands/".$now;
            $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
            Storage::putFileAs(
                'public'.$path,$data['image'],$imageName
            );
            $img = $path.'/'.$imageName;
        }else{
            $img = $this->imgedit;
        }
        
        $brand->name = $data['name'];
        $brand->image = $img;
        $brand->slug = Str::slug($data['name']);
        $brand->save();

        if ($brand) {
            $this->reset(['name','image']);
            session()->flash('success','Berhasil mengupdate Brand '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal mengupdate. Isi form dengan sesuai yah.');
        }
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Brand::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Brand::query()
        ->whereIn('id', $this->selected)->delete();
        if ($del) {
            session()->flash('success','Sukses menghapus data.');
            $this->selected = [];
            $this->selectAll = false;
        }else{
            session()->flash('failed','Gagal menghapus data.');
        }
    }

    public function updateSelectAll($value)
    {
        if ($value === true) {
            $this->selected = $this->brands->pluck('id');
        }
    }
}
