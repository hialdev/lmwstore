<?php

namespace App\Http\Livewire\Dash\User;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Header extends Component
{
    public $listeners = [
        'profileUpdate' => '$refresh',
    ];
    
    public function render()
    {
        $user = User::findOrFail(Auth::id());
        $uid = Auth::id();
        $count = Cart::where('id_user',$uid)->latest()->get();
        $count = count($count);

        return view('livewire.dash.user.header',[
            'user' => $user,
            'count' => $count,
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        redirect()->route('login');
    }
}
