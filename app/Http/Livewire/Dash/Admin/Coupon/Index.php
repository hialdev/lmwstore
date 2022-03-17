<?php

namespace App\Http\Livewire\Dash\Admin\Coupon;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q,$limit = 10,$editModal = true,$selectId;
    public $code,$discount,$max;
    public $check = [],$selected = [];
    protected $coupon;
    public $selectAll = false;

    public function render()
    {
        if ($this->q !== null) {
            $coupon = Coupon::where('code','like','%'.$this->q.'%')->latest();
        }else{
            $coupon = Coupon::latest();
        }

        $this->coupon = $coupon->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.coupon.index',[
            'coupon' => $this->coupon,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }

    public function blank()
    {
        $this->reset(['code','discount','max']);
    }
    
    public function add()
    {
        $data = $this->validate([
            'code' => 'required|string',
            'discount' => 'required',
            'max' => 'required',
        ]);

        $coupon = new Coupon();
        $coupon->code = $data['code'];
        $coupon->discount = $data['discount'];
        $coupon->max = $data['max'];
        $coupon->save();

        if ($coupon) {
            session()->flash('success','Berhasil menambahkan coupon '.$data['code']);
        }else{
            session()->flash('failed','Uupss maaf, gagal menambahkan. Isi form dengan sesuai yah.');
        }
    }
    
    public function edit($id)
    {
        $this->editModal = true;
        $cpn = Coupon::findOrFail($id);
        $this->code = $cpn->code;
        $this->discount = $cpn->discount;
        $this->max = $cpn->max;
        $this->selectId = $cpn->id;
    }

    public function update($id)
    {
        $cpn = Coupon::findOrFail($id);
        $cpn->code = $this->code;
        $cpn->discount = $this->discount;
        $cpn->max = $this->max;
        $cpn->save();

        $this->reset(['code','discount','max','selectId']);
        session()->flash('success','Berhasil memperbarui data.');
    }

    public function delSingle($id)
    {
        $this->selectId = $id;    
    }

    public function del($id)
    {
        Coupon::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $del = Coupon::query()
        ->whereIn('id', $this->selected)->delete();
        if ($del) {
            session()->flash('success','Sukses menghapus data.');
            $this->selected = [];
            $this->selectAll = false;
        }else{
            session()->flash('failed','Gagal menghapus data.');
        }
    }

    public function updateSelectAll($value)
    {
        if ($value === true) {
            $this->selected = $this->coupon->pluck('id');
        }
    }
}
