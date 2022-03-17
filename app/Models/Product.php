<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function brand()
    {
        return $this->belongsTo(Brand::class,'id_brand');
    }

    public function categories()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_product','id_product','id_kategori');
    }

    public function label()
    {
        return $this->belongsTo(Label::class,'id_label');
    }

}
