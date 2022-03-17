<?php

namespace App\Http\Livewire\Dash\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $q,$limit = 10,$selectId;
    public $name,$icon;
    public $check = [],$selected = [];
    protected $user;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $user = User::role('user')->where('name','like','%'.$this->q.'%')->latest();
        }else{
            $user = User::role('user')->latest();
        }

        $this->user = $user->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.users',[
            'user' => $this->user,
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

        $ctg = new User();
        $ctg->name = $data['name'];
        $ctg->icon = $data['icon'];
        $ctg->slug = Str::slug($data['name']);
        $ctg->save();

        if ($ctg) {
            session()->flash('success','Berhasil menambahkan User '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $ctg = User::findOrFail($id);
        $this->name = $ctg->name;
        $this->icon = $ctg->icon;
        $this->selectId = $ctg->id;
    }

    public function update($id)
    {
        $ctg = User::findOrFail($id);
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
        User::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = User::query()
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
            $this->selected = $this->user->pluck('id');
        }
    }
}
