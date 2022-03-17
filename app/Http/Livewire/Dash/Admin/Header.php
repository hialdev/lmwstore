<?php

namespace App\Http\Livewire\Dash\Admin;

use App\Models\Email;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {   
        $user = User::findOrFail(Auth::id());
        $email = Email::latest()->limit(4)->get();
        return view('livewire.dash.admin.header',[
            'user' => $user,
            'email' => $email,
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        redirect()->route('login');
    }
}
