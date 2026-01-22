<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Giay;
use App\Models\LoaiGiay;
use App\Models\ThuongHieu;
use App\Models\KhuyenMai;


class GiayController extends Controller
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hinh1 = "";
        $hinh2 = "";
        $hinh3 = "";
        $hinh4 = "";

        if($request->file('hinh_anh_1')){
            $filename1 = $request->file('hinh_anh_1');
            $hinh1 = $filename1->getClientOriginalName();
            $filename1 -> move(public_path('storage/images'), $hinh1);
        }
        if($request->file('hinh_anh_2')){
            $filename2 = $request->file('hinh_anh_2');
            $hinh2 = $filename2->getClientOriginalName();
            $filename2 -> move(public_path('storage/images'), $hinh2);
        } else {
            $hinh2 = $hinh1;
        }
        if($request->file('hinh_anh_3')){
            $filename3 = $request->file('hinh_anh_3');
            $hinh3 = $filename3->getClientOriginalName();
            $filename3 -> move(public_path('storage/images'), $hinh3);
        } else {
            $hinh3 = $hinh1;
        }
        if($request->file('hinh_anh_4')){
            $filename4 = $request->file('hinh_anh_4');
            $hinh4 = $filename4->getClientOriginalName();
            $filename4 -> move(public_path('storage/images'), $hinh4);
        } else {
            $hinh4 = $hinh1;
        }
       
        $giay = Giay::create([
            'ten_giay' => $request->input('ten_giay'),
            'ten_loai_giay' => $request->input('ten_loai_giay'),
            'ten_thuong_hieu' => $request->input('ten_thuong_hieu'),
            'mo_ta' => $request->input('mo_ta'),
            'don_gia' => $request->input('don_gia'),
            // 'so_luong' => $request->input('so_luong'),
            'sizes' => $request->input('sizes'),
            'hinh_anh_1' => $hinh1,
            'hinh_anh_2' => $hinh2,
            'hinh_anh_3' => $hinh3,
            'hinh_anh_4' => $hinh4,            
            'ten_khuyen_mai' => $request->input('ten_khuyen_mai'),
            'so_luong_mua' => '0',
            
        ]);

        return Redirect('/admin/giay');
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(123);
        // hiển thị
        $data = Giay::all();
        return View('admin.giay.giay', ['giays'=>$data]);
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $data = Giay::find($id);
    $loaigiays = LoaiGiay::all();
    $thuonghieus = ThuongHieu::all();
    $khuyenmais = KhuyenMai::all();

    $sizes = \DB::table('chitiet_giay')
        ->where('id_giay', $id)
        ->pluck('size')
        ->toArray();

    $sizes_str = implode(',', $sizes);

    return View('admin.giay.sua', [
        'giay' => $data,
        'sizes_str' => $sizes_str,
        'loaigiays' => $loaigiays,
        'thuonghieus' => $thuonghieus,
        'khuyenmais' => $khuyenmais
    ]);
}


    /**
     * 
     *
     * @param  \Illuminate\Http\Request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $giay = Giay::find($request->id_giay);

        if ($request->hasFile('hinh_anh_1')) {
            $filename1 = $request->file('hinh_anh_1');
            $giay->hinh_anh_1 = $filename1->getClientOriginalName();
            $filename1->move(public_path('storage/images'), $giay->hinh_anh_1);
        }

        if ($request->hasFile('hinh_anh_2')) {
            $filename2 = $request->file('hinh_anh_2');
            $giay->hinh_anh_2 = $filename2->getClientOriginalName();
            $filename2->move(public_path('storage/images'), $giay->hinh_anh_2);
        }

        if ($request->hasFile('hinh_anh_3')) {
            $filename3 = $request->file('hinh_anh_3');
            $giay->hinh_anh_3 = $filename3->getClientOriginalName();
            $filename3->move(public_path('storage/images'), $giay->hinh_anh_3);
        }

        if ($request->hasFile('hinh_anh_4')) {
            $filename4 = $request->file('hinh_anh_4');
            $giay->hinh_anh_4 = $filename4->getClientOriginalName();
            $filename4->move(public_path('storage/images'), $giay->hinh_anh_4);
        }

        $giay->ten_giay = $request->ten_giay;
        $giay->ten_loai_giay = $request->ten_loai_giay;
        $giay->ten_thuong_hieu = $request->ten_thuong_hieu;
        $giay->mo_ta = $request->mo_ta;
        $giay->don_gia = $request->don_gia;
        // $giay->so_luong = $request->so_luong;
        $giay->sizes = $request->sizes;
        $giay->ten_khuyen_mai = $request->ten_khuyen_mai;
        $giay->save();


        $sizes = explode(',', $request->sizes);
        foreach ($sizes as $size) {
        DB::table('chitiet_giay')->insert([
            'id_giay' => $giay->id_giay,
            'size' => trim($size),
            'so_luong' => 0, 
        ]);
    }

        return Redirect('/admin/giay');
    }

    /**
     * 
     *
     * @param  int 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /// xóa
        $data = Giay::find($id);
        $data->delete();
        return Redirect('/admin/giay');
    }

    public function showChiTietSanPham($id)
{
    $giay = Giay::with('chitiet')->find($id);
    
    if (!$giay) {
        abort(404);
    }

    session()->forget('error');

    return view('cuahang', compact('giay'));
}

}
