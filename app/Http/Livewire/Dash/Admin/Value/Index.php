<?php

namespace App\Http\Livewire\Dash\Admin\Value;

use App\Models\Value;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $title,$icon,$desc;
    public $check = [],$selected = [];
    protected $value;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $value = Value::where('title','like','%'.$this->q.'%')->latest()->get();
        }else{
            $value = Value::latest()->paginate($this->limit);
        }

        $this->value = $value;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.value.index',[
            'value' => $this->value,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'title' => 'required|string',
            'icon' => 'required',
            'desc' => 'required|string',
        ]);

        $ctg = new Value();
        $ctg->title = $data['title'];
        $ctg->icon = $data['icon'];
        $ctg->desc = $data['desc'];
        $ctg->save();

        if ($ctg) {
            $this->reset(['title','icon','desc']);
            session()->flash('success','Berhasil menambahkan Value '.$data['title']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $ctg = Value::findOrFail($id);
        $this->title = $ctg->title;
        $this->icon = $ctg->icon;
        $this->desc = $ctg->desc;
        $this->selectId = $ctg->id;
    }

    public function blank()
    {
        $this->reset(['title','icon','desc','selectId']);
    }
    
    public function update($id)
    {
        $ctg = Value::findOrFail($id);
        $ctg->title = $this->title;
        $ctg->icon = $this->icon;
        $ctg->desc = $this->desc;
        $ctg->save();

        $this->reset(['title','icon','desc','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Value::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Value::query()
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
            $this->selected = $this->value->pluck('id');
        }
    }
}
