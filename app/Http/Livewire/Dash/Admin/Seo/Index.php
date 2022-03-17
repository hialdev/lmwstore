<?php

namespace App\Http\Livewire\Dash\Admin\Seo;

use App\Models\Meta;
use App\Models\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $id_page,$title,$image,$imgedit,$desc,$type;
    public $check = [],$selected = [];
    protected $seo;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $seo = Meta::where('title','like','%'.$this->q.'%')->latest();
        }else{
            $seo = Meta::latest();
        }
        $pages = Page::all();
        $this->seo = $seo->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.seo.index',[
            'seo' => $this->seo,
            'pages' => $pages,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'id_page' => 'required|numeric',
            'desc' => 'required|string',
            'image' => 'required|image'
        ]);
        
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $path = "/media/images/seo/".$now;
        $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
        Storage::putFileAs(
            'public'.$path,$data['image'],$imageName
        );
        $img = $path.'/'.$imageName;

        $seo = new Meta();
        $seo->id_page = $data['id_page'];
        $seo->title = $data['title'];
        $seo->type = $data['type'];
        $seo->desc = $data['desc'];
        $seo->image = $img;
        $seo->save();

        if ($seo) {
            $this->reset(['title','type','id_page','desc','image']);
            session()->flash('success','Berhasil menambahkan Brand '.$data['title']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['title','type','id_page','desc','image']);
    }

    public function edit($id)
    {
        $this->image = null;
        $this->editModal = true;
        $seo = Meta::findOrFail($id);
        $this->id_page = $seo->id_page;
        $this->title = $seo->title;
        $this->type = $seo->type;
        $this->desc = $seo->desc;
        $this->imgedit = $seo->image;
        $this->selectId = $seo->id;
    }

    public function update($id)
    {
        $data = $this->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'id_page' => 'required|numeric',
            'desc' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        $seo = Meta::findOrFail($id);

        if ($data['image']) {
            if(File::exists('storage'.$this->imgedit)){
                File::delete('storage'.$this->imgedit);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/seo/".$now;
            $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
            Storage::putFileAs(
                'public'.$path,$data['image'],$imageName
            );
            $img = $path.'/'.$imageName;
        }else{
            $img = $this->imgedit;
        }

        $seo->id_page = $data['id_page'];
        $seo->title = $data['title'];
        $seo->type = $data['type'];
        $seo->desc = $data['desc'];
        $seo->image = $img;

        $seo->save();

        if ($seo) {
            $this->reset(['title','type','id_page','desc','image']);
            session()->flash('success','Berhasil mengupdate Brand '.$data['title']);
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
        Meta::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Meta::query()
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
            $this->selected = $this->seo->pluck('id');
        }
    }
}