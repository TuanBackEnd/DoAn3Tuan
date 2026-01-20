<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Giay;
use App\Models\LoaiGiay;
use App\Models\ThuongHieu;
use App\Models\KhuyenMai;
use App\Models\PhanQuyen;
use App\Models\DonHang;
use App\Models\Comment;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //     if (!Auth::check()) {
    //     return redirect()->route('login');
    // }
     $users = User::all();
            $giays = Giay::all();
            $loaigiays = LoaiGiay::all();
            $thuonghieus = ThuongHieu::all();
            $khuyenmais = KhuyenMai::all();
            $phanquyens = PhanQuyen::all();
            $donhangs = DonHang::all();

    return view('admin.index')
            // return view('admin.index')
            ->with('users', $users)
            ->with('giays', $giays)
            ->with('loaigiays', $loaigiays)
            ->with('thuonghieus', $thuonghieus)
            ->with('khuyenmais', $khuyenmais)
            ->with('phanquyens', $phanquyens)
            ->with('donhangs', $donhangs);
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
    public function update(Request $request, $id)
    {
        //
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
    }

    public function dieuhuong($slug)
{
    $thuonghieus = ThuongHieu::all();
    $loaigiays = LoaiGiay::all();
    $giays = Giay::all();
    $users = User::all();
    $khuyenmais = KhuyenMai::all();
    $phanquyens = PhanQuyen::all();
    $donhangs = DonHang::all();

    if ($slug === 'tonkho') {
        $tonkhos = \App\Models\ChiTietGiay::with('giay')->get();

        return view("admin.tonkho.tonkho")
            ->with(compact(
                'tonkhos', 'thuonghieus', 'loaigiays', 'giays',
                'users', 'khuyenmais', 'phanquyens', 'donhangs'
            ));
    }

    if ($slug === 'comment') {
        // Eager load product & customer
        $comments = Comment::with(['product', 'customer'])->get();

        return view("admin.comment.index", compact(
            'thuonghieus', 'loaigiays', 'giays', 'users',
            'khuyenmais', 'phanquyens', 'donhangs', 'comments'
        ));
    }
    if ($slug === 'contact') {
        return view("admin.contact.index")
            ->with(compact('thuonghieus', 'loaigiays', 'giays', 'users', 'khuyenmais', 'phanquyens', 'donhangs'));
    }


    return view("admin.{$slug}.{$slug}")
        ->with(compact('thuonghieus', 'loaigiays', 'giays', 'users', 'khuyenmais', 'phanquyens', 'donhangs'));
}

    

    public function dieuhuong2($slug, $slug2){
        // if(session()->get(key:'check') == 1){
        //     $data = User::where('id',session('DangNhap'))->first();
            $thuonghieus = ThuongHieu::all();
            $loaigiays = LoaiGiay::all();
            $giays = Giay::all();
            $users = User::all();
            $phanquyens = PhanQuyen::all();
            $khuyenmais = KhuyenMai::all();
            $donhangs = DonHang::all();

            return view("admin.{$slug}.{$slug2}")
            // ->with('data', $data)
            ->with('thuonghieus', $thuonghieus)
            ->with('loaigiays', $loaigiays)
            ->with('giays', $giays)
            ->with('users', $users)
            ->with('phanquyens', $phanquyens)
            ->with('khuyenmais', $khuyenmais)
            ->with('donhangs', $donhangs)
            ;
        // } else{
        //     return Redirect('/trang-chu');
        // }
    }

}
