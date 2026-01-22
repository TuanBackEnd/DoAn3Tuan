<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $table = 'yeu_cau_khach_hang'; 
    protected $fillable = [
        'ten',
        'email',
        'tin_nhan',
    ];

    // If you want to set custom timestamps
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}