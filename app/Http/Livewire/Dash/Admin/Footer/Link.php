<?php

namespace App\Http\Livewire\Dash\Admin\Footer;

use App\Models\FooterLink;
use App\Models\FooterSection;
use Livewire\Component;
use Livewire\WithPagination;

class Link extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $id_fs,$text,$url;
    public $check = [],$selected = [];
    protected $footers;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $footers = FooterLink::where('text','like','%'.$this->q.'%')->latest();
        }else{
            $footers = FooterLink::latest();
        }

        $this->footers = $footers->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        $sections = FooterSection::latest()->get();

        return view('livewire.dash.admin.footer.link',[
            'footers' => $this->footers,
            'sections' => $sections,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'id_fs' => 'required|numeric',
            'text' => 'required|string',
            'url' => 'required'
        ]);

        $foot = new FooterLink();
        $foot->id_footer = $data['id_fs'];
        $foot->foot_text = $data['text'];
        $foot->foot_url = $data['url'];
        $foot->save();

        if ($foot) {
            $this->reset(['id_fs','text','url','selectId']);
            session()->flash('success','Berhasil menambahkan FooterLink '.$data['text']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $foot = FooterLink::findOrFail($id);
        $this->id_fs = $foot->id_footer;
        $this->text = $foot->foot_text;
        $this->url = $foot->foot_url;
        $this->selectId = $foot->id;
    }

    public function blank()
    {
        $this->reset(['id_fs','text','url','selectId']);
    }

    public function update($id)
    {
        $foot = FooterLink::findOrFail($id);
        $foot->id_footer = $this->id_fs;
        $foot->foot_text = $this->text;
        $foot->foot_url = $this->url;
        $foot->save();

        $this->reset(['id_fs','text','url','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        FooterLink::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = FooterLink::query()
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
            $this->selected = $this->footers->pluck('id');
        }
    }
}
