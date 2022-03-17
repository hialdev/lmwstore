<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->belongsToMany(Product::class, 'kategori_product','id_kategori','id_product');
    }
}
