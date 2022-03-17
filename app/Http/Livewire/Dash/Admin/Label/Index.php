<?php

namespace App\Http\Livewire\Dash\Admin\Label;

use App\Models\Label;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $name,$bg_color;
    public $check = [],$selected = [];
    protected $label;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $label = Label::where('name','like','%'.$this->q.'%')->latest();
        }else{
            $label = Label::latest();
        }

        $this->label = $label->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.label.index',[
            'label' => $this->label,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'name' => 'required|string',
            'bg_color' => 'required'
        ]);

        $label = new Label();
        $label->name = $data['name'];
        $label->bg_color = $data['bg_color'];
        $label->save();

        if ($label) {
            session()->flash('success','Berhasil menambahkan label '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $ctg = Label::findOrFail($id);
        $this->name = $ctg->name;
        $this->bg_color = $ctg->bg_color;
        $this->selectId = $ctg->id;
    }

    public function update($id)
    {
        $lbl = Label::findOrFail($id);
        $lbl->name = $this->name;
        $lbl->bg_color = $this->bg_color;
        $lbl->save();

        $this->reset(['name','bg_color','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Label::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Label::query()
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
            $this->selected = $this->label->pluck('id');
        }
    }
}
