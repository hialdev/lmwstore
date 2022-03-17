<?php

namespace App\Http\Livewire\Dash\Admin\Banner;

use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $position = 'banner-content-center',$subtitle,$title,$image,$btn_text,$btn_url,$imgedit;
    public $check = [],$selected = [],$featured = [];
    protected $banners;
    public $selectAll = false;

    public function boot()
    {
        $banners = Banner::all();
        foreach ($banners as $b) {
            if ($b->featured === 1) {
                $this->featured[] = $b->id;
            }
        }
    }

    public function render()
    {
        if ($this->q !== null) {
            $banners = Banner::where('title','like','%'.$this->q.'%')->orWhere('subtitle','like','%'.$this->q.'%')->latest();
        }else{
            $banners = Banner::latest();
        }

        $this->banners = $banners->paginate($this->limit);

        $this->checkFeatured();
        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.banner.index',[
            'banners' => $this->banners,
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
            'btn_url' => 'required|string', 
            'position' => 'required|string',
            'image' => 'required|image'
        ]);
        
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $path = "/media/images/banners/".$now;
        $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
        Storage::putFileAs(
            'public'.$path,$data['image'],$imageName
        );
        $img = $path.'/'.$imageName;

        $banner = new banner();
        $banner->title = $data['title'];
        $banner->sub_title = $data['subtitle'];
        $banner->btn_text = $data['btn_text'];
        $banner->btn_url = $data['btn_url'];
        $banner->position = $data['position'];
        $banner->featured = 0;
        $banner->image = $img;
        $banner->save();

        if ($banner) {
            $this->reset(['title','subtitle','position','btn_text','btn_url','image']);
            session()->flash('success','Berhasil menambahkan banner '.$data['title']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['title','subtitle','image','btn_text','btn_url','selectId']);
    }

    public function edit($id)
    {
        $this->image = null;
        $this->editModal = true;
        $banner = Banner::findOrFail($id);
        $this->subtitle = $banner->sub_title;
        $this->title = $banner->title;
        $this->imgedit = $banner->image;
        $this->btn_text = $banner->btn_text;
        $this->btn_url = $banner->btn_url;
        $this->position = $banner->position;
        $this->selectId = $banner->id;
    }

    public function update($id)
    {
        $data = $this->validate([
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'btn_text' => 'required|string',
            'btn_url' => 'required|string',
            'position' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        $banner = Banner::findOrFail($id);

        if ($data['image']) {
            if(File::exists('storage'.$this->imgedit)){
                File::delete('storage'.$this->imgedit);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/banners/".$now;
            $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
            Storage::putFileAs(
                'public'.$path,$data['image'],$imageName
            );
            $img = $path.'/'.$imageName;
        }else{
            $img = $this->imgedit;
        }
        
        $banner->title = $data['title'];
        $banner->sub_title = $data['subtitle'];
        $banner->btn_text = $data['btn_text'];
        $banner->btn_url = $data['btn_url'];
        $banner->position = $data['position'];
        $banner->image = $img;
        $banner->save();

        if ($banner) {
            $this->reset(['title','subtitle','btn_text','btn_url','image']);
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
        Banner::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Banner::query()
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
            $this->selected = $this->banners->pluck('id');
        }
    }

    public function checkFeatured()
    {
        if (count($this->featured)>2) {
            $this->featured = array_slice($this->featured, 0, 2);
            $bnr = Banner::query()
            ->whereIn('id', $this->featured)->update(['featured' => 1]);
            if ($bnr) {
            }else{
                session()->flash('failed','Gagal featured banner.');
            }
        }elseif (count($this->featured) === 2){
            $bnr = Banner::query()
            ->whereIn('id', $this->featured)->update(['featured' => 1]);
            if ($bnr) {
            }else{
                session()->flash('failed','Gagal featured banner.');
            }
        }elseif (count($this->featured) === 1){
            $bnr = Banner::query()
            ->whereIn('id', $this->featured)->update(['featured' => 1]);
            if ($bnr) {
            }else{
                session()->flash('failed','Gagal featured banner.');
            }
        }

        //Syncornize Featured
        $banners = Banner::all();
        foreach ($banners as $bnr) {
            if (!in_array($bnr->id,$this->featured)) {
                Banner::find($bnr->id)->update(['featured'=>0]);
            }
        }
    }
}
