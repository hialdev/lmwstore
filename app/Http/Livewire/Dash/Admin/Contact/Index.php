<?php

namespace App\Http\Livewire\Dash\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $platform,$icon,$contact,$name,$url;
    public $check = [],$selected = [];
    protected $contacts;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $contacts = Contact::where('name','like','%'.$this->q.'%')->orWhere('platform','like','%'.$this->q.'%')->orWhere('contact','like','%'.$this->q.'%')->latest()->get();
        }else{
            $contacts = Contact::latest()->paginate($this->limit);
        }

        $this->contacts = $contacts;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.contact.index',[
            'contacts' => $this->contacts,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function add()
    {
        $data = $this->validate([
            'platform' => 'required|string',
            'name' => 'required|string',
            'contact' => 'required|string',
            'url' => 'required|string',
            'icon' => 'required',
        ]);

        $contact = new Contact();
        $contact->platform = $data['platform'];
        $contact->name = $data['name'];
        $contact->icon = $data['icon'];
        $contact->contact = $data['contact'];
        $contact->url = $data['url'];
        $contact->save();

        if ($contact) {
            $this->reset(['name','icon','contact','platform','url']);
            session()->flash('success','Berhasil menambahkan contacts '.$data['name']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $contact = Contact::findOrFail($id);
        $this->platform = $contact->platform;
        $this->icon = $contact->icon;
        $this->contact = $contact->contact;
        $this->name = $contact->name;
        $this->url = $contact->url;
        $this->selectId = $contact->id;
    }

    public function blank()
    {
        $this->reset(['name','icon','contact','platform','url','selectId']);
    }
    
    public function update($id)
    {
        $ctg = Contact::findOrFail($id);
        $ctg->title = $this->title;
        $ctg->icon = $this->icon;
        $ctg->desc = $this->desc;
        $ctg->save();

        $this->reset(['name','icon','contact','platform','url','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Contact::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Contact::query()
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
            $this->selected = $this->contacts->pluck('id');
        }
    }
}
