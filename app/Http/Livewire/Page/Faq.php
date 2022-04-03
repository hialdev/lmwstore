<?php

namespace App\Http\Livewire\Page;

use App\Models\Faq as ModelsFaq;
use App\Models\Page;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Faq extends Component
{
    public function mount()
    {
        $seo = Page::all()->keyBy('name');
        $s_index = $seo->get('faq')->meta;
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
        $faqs = ModelsFaq::all();
        return view('livewire.page.faq',compact('faqs'));
    }
}
