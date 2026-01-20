<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoa_don';
    public $timestamps = false;

    public function chiTietHoaDon()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'id_hd', 'id');
    }
}
