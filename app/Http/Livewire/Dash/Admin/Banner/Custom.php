<?php

namespace App\Http\Livewire\Dash\Admin\Banner;

use App\Models\BannerCustom;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Custom extends Component
{
    use WithFileUploads;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $subtitle,$title,$image,$btn_text,$url,$desc,$imgedit;
    public $check = [],$selected = [];
    protected $banner;
    public $selectAll = false;

    public function render()
    {
        $banner = BannerCustom::first();

        $this->banner = $banner;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.banner.custom',[
            'banner' => $this->banner,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'btn_text' => 'required|string',
            'url' => 'required|string', 
            'desc' => 'required|string',
            'image' => 'required|image'
        ]);
        
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $path = "/media/images/banners/".$now;
        $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
        Storage::putFileAs(
            'public'.$path,$data['image'],$imageName
        );
        $img = $path.'/'.$imageName;

        $banner = new BannerCustom();
        $banner->title = $data['title'];
        $banner->subtitle = $data['subtitle'];
        $banner->btn_text = $data['btn_text'];
        $banner->url = $data['url'];
        $banner->desc = $data['desc'];
        $banner->image = $img;
        $banner->save();

        if ($banner) {
            $this->reset(['title','subtitle','desc','btn_text','url','image']);
            session()->flash('success','Berhasil menambahkan banner '.$data['title']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['title','subtitle','image','btn_text','url','selectId']);
    }

    public function edit($id)
    {
        $this->image = null;
        $this->editModal = true;
        $banner = BannerCustom::findOrFail($id);
        $this->subtitle = $banner->subtitle;
        $this->title = $banner->title;
        $this->imgedit = $banner->image;
        $this->btn_text = $banner->btn_text;
        $this->url = $banner->url;
        $this->desc = $banner->desc;
        $this->selectId = $banner->id;
    }

    public function update($id)
    {
        $data = $this->validate([
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'btn_text' => 'required|string',
            'url' => 'required|string',
            'desc' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        $banner = BannerCustom::findOrFail($id);

        if ($data['image']) {
            if(File::exists('storage'.$this->imgedit)){
                File::delete('storage'.$this->imgedit);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/banner/".$now;
            $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
            Storage::putFileAs(
                'public'.$path,$data['image'],$imageName
            );
            $img = $path.'/'.$imageName;
        }else{
            $img = $this->imgedit;
        }
        
        $banner->title = $data['title'];
        $banner->subtitle = $data['subtitle'];
        $banner->btn_text = $data['btn_text'];
        $banner->url = $data['url'];
        $banner->desc = $data['desc'];
        $banner->image = $img;
        $banner->save();

        if ($banner) {
            $this->reset(['title','subtitle','btn_text','url','image']);
            session()->flash('success','Berhasil mengupdate banner '.$data['title']);
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
        BannerCustom::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = BannerCustom::query()
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
            $this->selected = $this->banner->pluck('id');
        }
    }

}
