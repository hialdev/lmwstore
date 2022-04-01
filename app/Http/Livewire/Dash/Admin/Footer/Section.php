<?php

namespace App\Http\Livewire\Dash\Admin\Footer;

use App\Models\FooterSection;
use Livewire\Component;
use Livewire\WithPagination;

class Section extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $section;
    public $check = [],$selected = [];
    protected $hal;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $hal = FooterSection::where('section','like','%'.$this->q.'%')->latest()->get();
        }else{
            $hal = FooterSection::latest()->paginate($this->limit);
        }
        
        $this->hal = $hal;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.footer.section',[
            'footers' => $this->hal,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'section' => 'required|string',
        ]);

        $foot = new FooterSection();
        $foot->section = $data['section'];
        $foot->save();

        if ($foot) {
            session()->flash('success','Berhasil menambahkan footer section '.$data['section']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['section']);    
    }

    public function edit($id)
    {
        $this->editModal = true;
        $foot = FooterSection::findOrFail($id);
        $this->section = $foot->section;
        $this->selectId = $foot->id;
    }

    public function update($id)
    {
        $foot = FooterSection::findOrFail($id);
        $foot->section = $this->section;
        $foot->save();

        $this->reset(['section','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        FooterSection::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = FooterSection::query()
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
