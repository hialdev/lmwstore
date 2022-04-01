<?php

namespace App\Http\Livewire\Page;

use App\Models\Contact as ModelsContact;
use App\Models\Email;
use App\Models\Setting;
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
        $contacts = ModelsContact::all();
        $setting = Setting::all()->keyBy('key');
        return view('livewire.page.contact',compact('contacts','setting'));
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
