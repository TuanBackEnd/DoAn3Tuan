<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chitiet_don_hang';
    protected $primaryKey = 'id_chitiet_don_hang'; 
    public $timestamps = false;

    protected $fillable = [
        'id_don_hang',
        'id_chitiet_giay',
        'so_luong',
        'gia',
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'id_don_hang', 'id_don_hang');
    }
    
    public function chitietGiay()
    {
        return $this->belongsTo(ChiTietGiay::class, 'id_chitiet_giay', 'id_chitiet_giay');
    }
    

//     public function giay()
// {
//     return $this->belongsTo(Giay::class, 'id_giay', 'id_giay');
// }

}
