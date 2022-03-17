<?php

namespace App\Http\Livewire\Dash\Admin\Email;

use App\Models\Email;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$viewModal = true,$selectId;
    public $mailId;
    public $check = [],$selected = [];
    protected $email;
    public $selectAll = false;

    public function boot()
    {  
        $check = Email::first();
        if ($check !== null) {
            $this->mailId = $check->id;
        }else{
            $this->mailId = null;
        }
    }

    public function render()
    {
        if ($this->q !== null) {
            $email = Email::where('subject','like','%'.$this->q.'%')->orWhere('email','like','%'.$this->q.'%')->orWhere('name','like','%'.$this->q.'%')->latest()->get();
        }else{
            $email = Email::latest()->paginate($this->limit);
        }

        $this->email = $email;

        $this->updateSelectAll($this->selectAll);
        if ($this->mailId !== null) {
            $mail = Email::findOrFail($this->mailId);
        }else{
            $mail = null;
        }

        return view('livewire.dash.admin.email.index',[
            'email' => $this->email,
            'mail' => $mail,
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

        $ctg = new Email();
        $ctg->name = $data['name'];
        $ctg->icon = $data['icon'];
        $ctg->slug = Str::slug($data['name']);
        $ctg->save();

        if ($ctg) {
            session()->flash('success','Berhasil menambahkan Email '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function view($id)
    {
        $this->viewModal = true;
        $this->mailId = $id;
    }

    public function update($id)
    {
        $ctg = Email::findOrFail($id);
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
        Email::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Email::query()
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
            $this->selected = $this->email->pluck('id');
        }
    }
}
