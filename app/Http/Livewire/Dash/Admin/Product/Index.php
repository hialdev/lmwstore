<?php

namespace App\Http\Livewire\Dash\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $q,$limit = 10;
    public $check = [],$selectedProducts = [];
    protected $products;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $products = Product::where('name','like','%'.$this->q.'%')->orWhere('brief','like','%'.$this->q.'%')->latest()->get();
        }else{
            $products = Product::latest()->paginate($this->limit);
        }

        $this->products = $products;

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.product.index',[
            'products' => $this->products,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function delProduct($id)
    {
        Product::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Product::query()
        ->whereIn('id', $this->selectedProducts)->delete();
        if ($del) {
            session()->flash('success','Sukses menghapus data.');
            $this->selectedProducts = [];
            $this->selectAll = false;
        }else{
            session()->flash('failed','Gagal menghapus data.');
        }
    }

    public function updateSelectAll($value)
    {
        if ($value === true) {
            $this->selectedProducts = $this->products->pluck('id');
        }
    }
}
