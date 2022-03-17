<?php

namespace App\Http\Livewire\Dash\Admin\Faq;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $title,$desc;
    public $check = [],$selected = [];
    protected $faq;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $faq = Faq::where('title','like','%'.$this->q.'%')->orWhere('desc','like','%'.$this->q.'%')->latest()->get();
        }else{
            $faq = Faq::latest()->paginate($this->limit);
        }

        $this->faq = $faq;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.faq.index',[
            'faq' => $this->faq,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'title' => 'required|string',
            'desc' => 'required|string',
        ]);

        $faq = new Faq();
        $faq->title = $data['title'];
        $faq->desc = $data['desc'];
        $faq->save();

        if ($faq) {
            $this->reset(['title','desc']);
            session()->flash('success','Berhasil menambahkan faq '.$data['title']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $faq = Faq::findOrFail($id);
        $this->title = $faq->title;
        $this->desc = $faq->desc;
        $this->selectId = $faq->id;
    }

    public function blank()
    {
        $this->reset(['title','desc','selectId']);
    }
    
    public function update($id)
    {
        $ctg = Faq::findOrFail($id);
        $ctg->title = $this->title;
        $ctg->desc = $this->desc;
        $ctg->save();

        $this->reset(['title','desc','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Faq::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Faq::query()
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
            $this->selected = $this->faq->pluck('id');
        }
    }
}
