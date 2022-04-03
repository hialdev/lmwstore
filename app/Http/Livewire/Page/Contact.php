<?php

namespace App\Http\Livewire\Page;

use App\Models\Contact as ModelsContact;
use App\Models\Email;
use App\Models\Page;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Contact extends Component
{
    public $name,$email,$phone,$subject,$message;

    public function mount()
    {
        $seo = Page::all()->keyBy('name');
        $s_index = $seo->get('contact')->meta;
        SEOTools::setTitle($s_index->title);
        SEOTools::setDescription($s_index->desc);
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', $s_index->type);
        SEOTools::twitter()->setSite($s_index->title);
        SEOTools::jsonLd()->addImage(asset('storage'.$s_index->image));
    }

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
