<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;
    protected $table = 'lien_he'; // Định nghĩa tên bảng

    // Định nghĩa các trường có thể gán giá trị hàng loạt
    protected $fillable = [
        'ten_cua_hang',       // Tên cửa hàng
        'dia_chi',            // Địa chỉ
        'so_dien_thoai',      // Số điện thoại
        'email',              // Email
        'fax',                // Fax
        'gio_lam_viec',       // Giờ làm việc
        'link_mang_xa_hoi',   // Liên kết mạng xã hội
        'ban_do',             // Bản đồ
    ];

    // If you want to set custom timestamps
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
