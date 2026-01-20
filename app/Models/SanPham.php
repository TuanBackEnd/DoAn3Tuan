<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';
    public $timestamps = false;

    public function chiTietSanPham()
    {
        return $this->hasMany(ChiTietSanPham::class, 'id_sp', 'id');
    }
}
