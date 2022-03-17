<?php

namespace App\Http\Livewire\Dash\Admin\Category;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $name,$icon;
    public $check = [],$selected = [];
    protected $category;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $category = Kategori::where('name','like','%'.$this->q.'%')->latest();
        }else{
            $category = Kategori::latest();
        }

        $this->category = $category->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.category.index',[
            'category' => $this->category,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'name' => 'required|string',
            'icon' => 'required'
        ]);

        $ctg = new Kategori();
        $ctg->name = $data['name'];
        $ctg->icon = $data['icon'];
        $ctg->slug = Str::slug($data['name']);
        $ctg->save();

        if ($ctg) {
            session()->flash('success','Berhasil menambahkan kategori '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $ctg = Kategori::findOrFail($id);
        $this->name = $ctg->name;
        $this->icon = $ctg->icon;
        $this->selectId = $ctg->id;
    }

    public function update($id)
    {
        $ctg = Kategori::findOrFail($id);
        $ctg->name = $this->name;
        $ctg->icon = $this->icon;
        $ctg->slug = Str::slug($this->name);
        $ctg->save();

        $this->reset(['name','icon','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Kategori::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Kategori::query()
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
            $this->selected = $this->category->pluck('id');
        }
    }
}
