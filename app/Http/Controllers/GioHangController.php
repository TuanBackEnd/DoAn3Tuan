<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;
use App\Models\Giay;
use App\Models\LoaiGiay;
use App\Models\ThuongHieu;
use App\Models\KhuyenMai;
use App\Models\GioHang;
use App\Models\PhanQuyen;
use App\Models\ChiTietGiay;

class GioHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('id',session('DangNhap'))->first();
        $thuonghieus = ThuongHieu::all();
        $loaigiays = LoaiGiay::all();
        $giays = Giay::all();
        $users = User::all();
        $phanquyens = PhanQuyen::all();
        $khuyenmais = KhuyenMai::all();

        $giohangs = session()->get(key:'gio_hang');
        if(!$giohangs){
            $giohangs = array();
        }
        
        return view('index')->with('route', 'gio-hang')
        ->with('data', $data)
        ->with('thuonghieus', $thuonghieus)
        ->with('loaigiays', $loaigiays)
        ->with('giays', $giays)
        ->with('users', $users)
        ->with('phanquyens', $phanquyens)
        ->with('khuyenmais', $khuyenmais)
        ->with('giohangs', $giohangs)
        ;
    }

    public function themvaogiohang(Request $request, $id) {
        $giay = Giay::find($id);

        if (!$giay) {
            return back()->with('error', 'Sản phẩm không tồn tại!');
        }
        // if ($giay->so_luong <= 0) {
        //     return back()->with('error', 'Sản phẩm đã hết hàng!');
        // }
        if (!empty($giay->sizes) && !$request->has('size')) {
            return back()->with('error', 'Vui lòng chọn size giày!');
        }

        $size = $request->input('size');

        $ct = \App\Models\ChiTietGiay::where('id_giay', $giay->id_giay)
        ->where('size', $size)
        ->first();

        if (!$ct || $ct->so_luong <= 0) {
        return back()->with('error', 'Sản phẩm đã hết hàng!');
    }
        $cart = session()->get('gio_hang', []);
        $cartItemId = $size ? $id . '-' . $size : $id;

        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['so_luong']++;
        } else {
            $khuyenmaiValue = 0;
            $khuyenmai = KhuyenMai::where('ten_khuyen_mai', $giay->ten_khuyen_mai)->first();
            if ($khuyenmai) {
                $khuyenmaiValue = $khuyenmai->gia_tri_khuyen_mai;
            }

            $cart[$cartItemId] = [
                "id_giay" => $giay->id_giay,
                "ten_giay" => $giay->ten_giay,
                "hinh_anh_1" => $giay->hinh_anh_1,
                "don_gia" => $giay->don_gia,
                "so_luong" => 1,
                "khuyen_mai" => $khuyenmaiValue,
                "size" => $size
            ];
        }

        session()->put('gio_hang', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    $gio_hang = session()->get('gio_hang');

    if (!isset($gio_hang[$request->id])) {
        return Redirect('/gio-hang')->with('error', 'Sản phẩm không tồn tại trong giỏ!');
    }

    $cartItem = $gio_hang[$request->id];
    $size = $cartItem['size'] ?? null;

    $ct = ChiTietGiay::where('id_giay', $cartItem['id_giay'])
        ->where('size', $size)
        ->first();

    if (!$ct) {
        return Redirect('/gio-hang')->with('error', 'Không tìm thấy tồn kho cho sản phẩm!');
    }

    if ($request->so_luong > $ct->so_luong) {
        return Redirect('/gio-hang')->with('error', 'Số lượng vượt quá tồn kho!');
    }

    if ($request->so_luong < 1) {
        return Redirect('/gio-hang')->with('error', 'Số lượng phải lớn hơn 0!');
    }

    $gio_hang[$request->id]['so_luong'] = $request->so_luong;
    session()->put('gio_hang', $gio_hang);

    return Redirect('/gio-hang')->with('success', 'Đã cập nhật giỏ hàng!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $gio_hang = session()->get(key:'gio_hang');

        unset($gio_hang[$id]);
        session()->put('gio_hang', $gio_hang);
        return Redirect('/gio-hang');

    }
}
