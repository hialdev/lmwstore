<?php

namespace App\Http\Livewire\Page;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        SEOTools::setTitle('LMW Store - Fashion Batik Betawi Terbaik');
        SEOTools::setDescription('This is my page description');
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'pages');
        SEOTools::twitter()->setSite('LMW Store - Fashion Batik Betawi Terbaik');
        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');
    }
    public function render()
    {
        return view('livewire.page.index');
    }
}
