<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->hasOne(User::class,'id','id_user');
    }

    public function alamat()
    {
        return $this->hasOne(Alamat::class,'id','id_alamat');
    }

    public function details()
    {
        return $this->hasOne(PesananDetail::class,'id_pesanan');
    }

    public static function detail($id)
    {
        return PesananDetail::where('id_pesanan',$id)->latest()->get();
    }
}
