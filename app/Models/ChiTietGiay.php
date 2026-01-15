<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietGiay extends Model
{
    protected $table = 'chitiet_giay';
    protected $primaryKey = 'id_chitiet_giay';
    public $timestamps = false;

    protected $fillable = [
        'id_chitiet_giay',
        'id_giay',
        'size',
        'so_luong'
    ];

    public function giay()
    {
        return $this->belongsTo(Giay::class, 'id_giay', 'id_giay');
    }


}
