<?php

namespace App\Http\Livewire\Dash\Admin\Page;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $name;
    public $check = [],$selected = [];
    protected $hal;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $hal = Page::where('name','like','%'.$this->q.'%')->latest()->get();
        }else{
            $hal = Page::latest()->paginate($this->limit);
        }

        $this->hal = $hal;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.page.index',[
            'pages' => $this->hal,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'name' => 'required|string',
        ]);

        $ctg = new Page();
        $ctg->name = $data['name'];
        $ctg->save();

        if ($ctg) {
            session()->flash('success','Berhasil menambahkan Page '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['name']);    
    }

    public function edit($id)
    {
        $this->editModal = true;
        $ctg = Page::findOrFail($id);
        $this->name = $ctg->name;
        $this->selectId = $ctg->id;
    }

    public function update($id)
    {
        $ctg = Page::findOrFail($id);
        $ctg->name = $this->name;
        $ctg->save();

        $this->reset(['name','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Page::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Page::query()
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
            $this->selected = $this->hal->pluck('id');
        }
    }
}
