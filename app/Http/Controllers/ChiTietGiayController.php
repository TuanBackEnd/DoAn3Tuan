<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietSanPham;
use App\Models\Giay;
use App\Models\ChiTietGiay;

class ChiTietGiayController extends Controller
{
    // Form thêm
    public function create($id)
{
    $giay = Giay::with('chitiet')->where('id_giay', $id)->firstOrFail();
    return view('admin.them_chitiet_giay', compact('giay'));
}

    public function store(Request $request)
    {
        $request->validate([
            'id_giay' => 'required|exists:giay,id_giay',
            'size' => 'required',
            'so_luong' => 'required|integer|min:0',
        ]);
    
        ChiTietGiay::create([
            'id_giay' => $request->id_giay,
            'size' => $request->size,
            'so_luong' => $request->so_luong,
        ]);
    
        return redirect()->back()->with('success', 'Thêm chi tiết giày thành công!');
    }

    public function laySoLuong($id_giay, $size)
    {
        $ct = \App\Models\ChiTietGiay::where('id_giay', $id_giay)
            ->where('size', $size)
            ->first();
    
            if (!$ct) {
                return response()->json(['so_luong' => 0, 'debug' => 'Không tìm thấy size']);
            }
            
        return response()->json([
            'so_luong' => $ct ? $ct->so_luong : 0
        ]);
    }
    
    public function chiTietGiay($id)
{
    session()->forget('error');
    $giay = Giay::with('chitiet')->findOrFail($id);
    return view('cuahang', compact('giay'));
}
    

}
