<?php

namespace App\Http\Livewire\Page;

use App\Models\Contact as ModelsContact;
use App\Models\Email;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public $name,$email,$phone,$subject,$message;

    public function render()
    {
        $contacts = ModelsContact::all();
        $setting = Setting::all()->keyBy('key');
        return view('livewire.page.contact',compact('contacts','setting'));
    }

    public function sendEmail()
    {
        $data = $this->validate([
            'name' => 'required|min:4',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'subject' => 'required|min:10',
            'message' => 'required|min:14',
        ]);

        try {

            $receiver = Setting::where('key','webmail')->first()->content;

            Mail::to($receiver)->send(new \App\Mail\LMWMail($data));
            $mail = Email::create([
                 'name' => $this->name,
                 'email' => $this->email,
                 'phone' => $this->phone,
                 'subject' => $this->subject,
                 'message' => $this->message,
            ]);

            if ($mail) {
                session()->flash('success','Hooray... Email berhasil dikirim!');
                $this->reset(['name','email','phone','subject','message']);
            }else{
                session()->flash('failed','Maaf gagal mengirim email :D');
            }
        } catch (\Exception $e) {
            session()->flash('failed','Maaf gagal mengirim email :D. Error : '.$e->getMessage());
        }
    }
}
