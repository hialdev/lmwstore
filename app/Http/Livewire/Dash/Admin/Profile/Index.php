<?php

namespace App\Http\Livewire\Dash\Admin\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $image,$name,$username,$email,$phone,$showUpdate = false, $showChange = false;
    public $password,$newpassword,$cnewpassword;

    public function boot()
    {
        $this->setup();
    }

    public function render()
    {
        $user = User::findOrFail(Auth::id());

        return view('livewire.page.profile',[
            'user' => $user,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function setup()
    {
        $user = User::findOrFail(Auth::id());
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function onUpdate()
    {
        $this->showChange = false;
        $this->showUpdate = true;
    }

    public function onChange()
    {
        $this->showUpdate = false;
        $this->showChange = true;
    }

    public function updateProfile($id)
    {
        $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email',
            'username' => 'nullable|unique:users,username,'.$id.',id|regex:/^\S*$/u',
            'phone' => 'nullable|numeric',
            'image' => 'nullable|image',
        ]);

        $user = User::findOrFail($id);
        if (isset($this->image)) {
            $path = "/media/images/user/$id";
            $imageName = md5($this->image.microtime().'.'.$this->image->extension());

            Storage::putFileAs(
                'public'.$path,$this->image,$imageName
            );

            $user->image = $path.'/'.$imageName;
        }
        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->save();
        
        if ($user) {
            session()->flash('success','Berhasil memperbarui profil.');
        }else{
            session()->flash('failed','Maaf, gagal memperbarui profil.');
        }

        $this->emit('profileUpdate');
    }

    public function updatePassword($id)
    {
        $data = $this->validate([
            'password' => 'nullable|min:6',
            'newpassword' => 'nullable|min:6',
            'cnewpassword' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        if ($data['newpassword'] === $data['cnewpassword']) {
            if (Hash::check($data['password'],$user->password)) {
                $user->password = Hash::make($data['newpassword']);
                $user->save();

                $this->reset(['password','cnewpassword','newpassword']);
                session()->flash('success','Horey, Password anda berhasil diubah.');
            }else{
                session()->flash('failed','Password sekarang / masa kini anda salah, pastikan password anda sesuai');
            }
        }else{
            session()->flash('failed','Password tidak matching, pastikan konfirmasi password anda sesuai');
        }
    }

    public function close()
    {
        $this->showChange = false;
        $this->showUpdate = false;
    }
}
