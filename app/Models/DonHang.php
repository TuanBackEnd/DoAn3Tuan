<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChiTietDonHang;


class DonHang extends Model
{
    use HasFactory;

    protected $table = "don_hang";

    protected $primaryKey = "id_don_hang";
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'id_khach_hang',
        'ten_nguoi_nhan',
        'sdt',
        'dia_chi_nhan',
        'ghi_chu',
        'tong_tien',
        'hinh_thuc_thanh_toan',
        'hoa_don',
        'trang_thai',
    ];

    // Dùng accessor để đổi tên trạng thái hiển thị
    public function getTrangThaiTextAttribute()
    {
        $status = [
            'Chờ duyệt' => 'Chờ duyệt',
            'Đã duyệt' => 'Đã duyệt',
            'Đang chuẩn bị hàng' => 'Đang chuẩn bị hàng',
            'Đang giao hàng' => 'Đang giao hàng',
            'Đã giao' => 'Đã giao',
        ];
        return $status[$this->trang_thai] ?? $this->trang_thai;
    }

    public function chitietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'id_don_hang', 'id_don_hang');
    }
}
