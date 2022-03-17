<?php

namespace App\Http\Livewire\Dash\Admin\Pesanan;

use App\Models\Coupon;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q = '',$limit = 10,$editModal = true,$selectId,$filter = '0';
    public $name,$icon,$slct_pesanan,$coupon,$details;
    public $check = [],$selected = [];
    protected $pesanan;
    public $selectAll = false;

    public function boot()
    {
        $pesanan = Pesanan::latest()->first();
        if ($pesanan !== null) {
            $this->slct_pesanan = $pesanan;
            $this->details = PesananDetail::where('id_pesanan',$pesanan->id)->get();
            $cpn = Coupon::where('code',$this->slct_pesanan->coupon)->first();
            if (isset($cpn)) {
                $this->coupon = $cpn;
            }else{
                $this->coupon = null;
            }
        }else{
            $this->slct_pesanan = null;
        }
        
    }

    public function render()
    {

        if ($this->filter !== null) {
            if ($this->filter === '1') {
                $pesanan = Pesanan::latest();
            }elseif ($this->filter === '2') {
                $pesanan = Pesanan::orderBy('created_at','ASC');
            }elseif ($this->filter === '3') {
                $pesanan = Pesanan::where('status',1)->latest();
            }elseif ($this->filter === '4') {
                $pesanan = Pesanan::where('status',0)->latest();
            }elseif ($this->filter === '0'){
                $pesanan = Pesanan::latest();
            }
        }
        if ($this->q !== null) {
            $pesanan = $pesanan->where('kode_pesanan','like','%'.$this->q.'%');
        }
        
        $this->pesanan = $pesanan->paginate($this->limit);

        $this->updateSelectAll($this->selectAll);
        
        return view('livewire.dash.admin.pesanan.index',[
            'pesanan' => $this->pesanan,
        ])
        ->extends('layouts.dashadmin')
        ->section('body');
    }
    
    public function detail($id)
    {
        $this->slct_pesanan = Pesanan::findOrFail($id);
        $this->details = PesananDetail::where('id_pesanan',$id)->get();
        $cpn = Coupon::where('code',$this->slct_pesanan->coupon)->first();
        if (isset($cpn)) {
            $this->coupon = $cpn;
        }else{
            $this->coupon = null;
        }
    }  

    public function confirmSingle($id)
    {
        $this->selectId = $id;
    }

    public function unconfirm($id)
    {
        $unconfirm  = Pesanan::findOrFail($id);
        $unconfirm->status = 0;
        $unconfirm->save();
        if ($unconfirm) {
            session()->flash('success','Berhasil batalkan konfirmasi pesanan '.$unconfirm->kode_pesanan);
        }else{
            session()->flash('failed','Uups... gagal batalkan konfirmasi pesanan');
        }   
    }

    public function confirm()
    {
        $confirm  = Pesanan::findOrFail($this->selectId);
        $confirm->status = 1;
        $confirm->save();
        if ($confirm) {
            session()->flash('success','Berhasil mengkonfirmasi pesanan '.$confirm->kode_pesanan);
        }else{
            session()->flash('failed','Uups... gagal mengkonfirmasi pesanan');
        }
    }

    public function confirmSelected()
    {
        $del = Pesanan::query()
        ->whereIn('id', $this->selected)->update(['status' => 1]);
        if ($del) {
            session()->flash('success','Sukses mengupdate data.');
            $this->selected = [];
            $this->selectAll = false;
        }else{
            session()->flash('failed','Gagal mengupdate data.');
        }
    }

    public function updateSelectAll($value)
    {
        if ($value === true) {
            $this->selected = $this->pesanan->pluck('id');
        }
    }
}
