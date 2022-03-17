<?php

namespace App\Http\Livewire\Page;

use App\Models\Email;
use Livewire\Component;

class Contact extends Component
{
    public $name,$email,$phone,$subject,$message;

    protected $rules = [
        'name' => 'required|min:4',
        'email' => 'required|email',
        'phone' => 'required|numeric',
        'subject' => 'required|min:10',
        'message' => 'required|min:14',
    ];

    public function render()
    {
        return view('livewire.page.contact');
    }

    public function sendEmail()
    {
        $this->validate();

        $email = Email::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        if ($email) {
            session()->flash('success','Hooray... Email berhasil dikirim!');
            $this->reset(['name','email','phone','subject','message']);
        }
    }
}
