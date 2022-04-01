<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSection extends Model
{
    use HasFactory;
    public function footer()
    {
        return $this->hasMany(FooterLink::class,'id_footer');
    }
}
