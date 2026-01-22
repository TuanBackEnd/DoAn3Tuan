<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietGiay;
use App\Models\Giay;
use App\Models\LoaiGiay;
use App\Models\ThuongHieu;
use App\Models\User;
use App\Models\KhuyenMai;
use App\Models\PhanQuyen;
use App\Models\DonHang;

class TonKhoController extends Controller
{
    public function index()
    {
        $tonkhos = ChiTietGiay::with('giay')->get();
        $thuonghieus = ThuongHieu::all();
        $loaigiays = LoaiGiay::all();
        $giays = Giay::all();
        $users = User::all();
        $khuyenmais = KhuyenMai::all();
        $phanquyens = PhanQuyen::all();
        $donhangs = DonHang::all();

        return view("admin.tonkho.tonkho", compact(
            'tonkhos', 'thuonghieus', 'loaigiays', 'giays',
            'users', 'khuyenmais', 'phanquyens', 'donhangs'
        ));
    }
    public function nhapThem(Request $request)
{
    $request->validate([
        'id_chitiet_giay' => 'required|exists:chitiet_giay,id_chitiet_giay',
        'so_luong_nhap' => 'required|integer|min:1',
    ]);

    $chiTietGiay = ChiTietGiay::find($request->id_chitiet_giay);
    $chiTietGiay->so_luong += $request->so_luong_nhap;
    $chiTietGiay->save();

    return redirect()->back()->with('success', 'Đã nhập thêm tồn kho thành công!');
}

}
