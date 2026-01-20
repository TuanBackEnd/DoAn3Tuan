<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function thongKe()
    {
        $thongke = DB::table('chitiet_don_hang')
            ->join('chitiet_giay', 'chitiet_don_hang.id_chitiet_giay', '=', 'chitiet_giay.id_chitiet_giay')
            ->join('giay', 'chitiet_giay.id_giay', '=', 'giay.id_giay')
            ->select(
                'giay.ten_giay',
                'chitiet_don_hang.id_chitiet_giay',
                DB::raw('SUM(chitiet_don_hang.so_luong) as da_ban')
            )
            ->groupBy('chitiet_don_hang.id_chitiet_giay', 'giay.ten_giay')
            ->orderByDesc('da_ban')
            ->limit(5)
            ->get();
    
        return view('admin.thongke.thongke', compact('thongke'));
    }
    
}
