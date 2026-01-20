<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'danh_gia'; 
    protected $primaryKey = 'id_danh_gia';
    protected $fillable = ['id','id_user', 'ten_danh_gia', 'danh_gia', 'danh_gia_binh_luan','id_giay'];

    // Quan hệ với bảng khách hàng (customer)
    public function customer()
    {
        return $this->belongsTo(User::class, 'id_user','id'); 
    }

    public function product()
    {
        return $this->belongsTo(Giay::class, 'id_giay','id_giay'); 
    }
}