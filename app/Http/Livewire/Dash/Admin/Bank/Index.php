<?php

namespace App\Http\Livewire\Dash\Admin\Bank;

use App\Models\Bank;
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
    public $bank,$rek,$name,$image,$imgedit;
    public $check = [],$selected = [];
    protected $banks;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $banks = Bank::where('name','like','%'.$this->q.'%')->latest()->get();
        }else{
            $banks = Bank::latest()->paginate($this->limit);
        }

        $this->banks = $banks;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.bank.index',[
            'banks' => $this->banks,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'bank' => 'required|string',
            'name' => 'required|string',
            'rek' => 'required|string',
            'image' => 'required|image'
        ]);
        
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $path = "/media/images/banks/".$now;
        $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
        Storage::putFileAs(
            'public'.$path,$data['image'],$imageName
        );
        $img = $path.'/'.$imageName;

        $bank = new Bank();
        $bank->bank = $data['bank'];
        $bank->rek = $data['rek'];
        $bank->name = $data['name'];
        $bank->logo = $img;
        $bank->save();

        if ($bank) {
            $this->reset(['bank','rek','name','image']);
            session()->flash('success','Berhasil menambahkan bank '.$data['bank']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function blank()
    {
        $this->reset(['bank','rek','name','image','selectId']);
    }

    public function edit($id)
    {
        $this->image = null;
        $this->editModal = true;
        $bank = Bank::findOrFail($id);
        $this->bank = $bank->bank;
        $this->rek = $bank->rek;
        $this->name = $bank->name;
        $this->imgedit = $bank->logo;
        $this->selectId = $bank->id;
    }

    public function update($id)
    {
        $data = $this->validate([
            'bank' => 'required|string',
            'name' => 'required|string',
            'rek' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        $bank = Bank::findOrFail($id);

        if ($data['image']) {
            if(File::exists('storage'.$this->imgedit)){
                File::delete('storage'.$this->imgedit);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/banks/".$now;
            $imageName = md5($data['image'].microtime().'.'.$data['image']->extension());
            Storage::putFileAs(
                'public'.$path,$data['image'],$imageName
            );
            $img = $path.'/'.$imageName;
        }else{
            $img = $this->imgedit;
        }
        
        $bank->bank = $data['bank'];
        $bank->rek = $data['rek'];
        $bank->name = $data['name'];
        $bank->logo = $img;
        $bank->save();

        if ($bank) {
            $this->reset(['bank','rek','name','image']);
            session()->flash('success','Berhasil mengupdate bank '.$data['bank']);
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
        Bank::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Bank::query()
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
            $this->selected = $this->banks->pluck('id');
        }
    }
}
