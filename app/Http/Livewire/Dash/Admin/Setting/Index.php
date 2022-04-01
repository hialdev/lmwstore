<?php

namespace App\Http\Livewire\Dash\Admin\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $logo,$favicon,$desc_site,$wa_admin,$address,$gmaps,$webmail;

    public function mount()
    {
        $this->setData();
    }
    
    public function render()
    {
        return view('livewire.dash.admin.setting.index',[
            
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function setData()
    {
        $data = Setting::all()->keyBy('key');
        $this->logo = $data->get('logo_site')->content;
        $this->favicon = $data->get('logo_favicon')->content;
        $this->desc_site = $data->get('desc_site')->content;
        $this->wa_admin = $data->get('wa_admin')->content;
        $this->webmail = $data->get('webmail')->content;
        $this->address = $data->get('address')->content;
        $this->gmaps = $data->get('gmaps')->content;
    }

    public function save()
    {
        $data = $this->validate([
            'logo' => 'image|nullable',
            'favicon' => 'image|nullable',
            'desc_site' => 'required|string',
            'wa_admin' => 'required|string',
            'webmail' => 'required|string',
            'address' => 'required|string',
            'gmaps' => 'required|string',
        ]);
        
        //Setting Data
        $set = Setting::all()->keyBy('key');

        if ($data['logo']) {
            if(File::exists('storage'.$this->logo)){
                File::delete('storage'.$this->logo);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/settings/logo/".$now;
            $imageName = 'logo-'.md5($data['logo'].microtime().'.'.$data['logo']->extension());
            Storage::putFileAs(
                'public'.$path,$data['logo'],$imageName
            );
            $logo = $path.'/'.$imageName;
        }else{
            $logo = $set->get('logo_site')->content;
        }

        if ($data['favicon']) {
            if(File::exists('storage'.$this->logo)){
                File::delete('storage'.$this->logo);
            }
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $path = "/media/images/settings/logo/".$now;
            $imageName = 'favicon-'.md5($data['favicon'].microtime().'.'.$data['favicon']->extension());
            Storage::putFileAs(
                'public'.$path,$data['favicon'],$imageName
            );
            $favicon = $path.'/'.$imageName;
        }else{
            $favicon = $set->get('logo_favicon')->content;
        }

        //Update
        $set->get('logo_site')->update(['content'=>$logo]);
        $set->get('logo_favicon')->update(['content'=>$favicon]);
        $set->get('wa_admin')->update(['content'=>$this->wa_admin]);
        $set->get('webmail')->update(['content'=>$this->webmail]);
        $set->get('address')->update(['content'=>$this->address]);
        $set->get('gmaps')->update(['content'=>$this->gmaps]);

        //Check
        if ($set) {
            session()->flash('success','Berhasil memperbarui settings ');
        }else{
            session()->flash('failed','Uupss maaf, gagal memperbarui settings. Isi form dengan sesuai yah.');
        }
    }
}
