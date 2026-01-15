<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThuongHieuController;
use App\Http\Controllers\LoaiGiayController;
use App\Http\Controllers\GiayController;
use App\Http\Controllers\KhuyenMaiController;
use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\ThayDoiTaiKhoanController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactInquiryController;
use App\Http\Controllers\TonKhoController;
use App\Http\Controllers\ChiTietGiayController;
use App\Http\Controllers\ThongKeController;

// ----------------- CLIENT ----------------- 
Route::get('/', [MainController::class, 'index']);
Route::get('/trang-chu', [MainController::class, 'index']);
Route::get('/cua-hang', [MainController::class, 'cuahang']);
Route::get('/cua-hang/loaigiay={loaigiay}', [MainController::class, 'timloaigiay']);
Route::get('/cua-hang/thuonghieu={thuonghieu}', [MainController::class, 'timthuonghieu']);
Route::get('/cua-hang/gia={gia1}-{gia2}', [MainController::class, 'timgia']);
Route::get('/cua-hang/san-pham={slug}', [MainController::class, 'sanpham']);
Route::post('/tim-kiem', [MainController::class, 'timkiem']);
Route::get('/gioi-thieu', [MainController::class, 'aboutUs']);
Route::get('/lich-su-mua-hang', [DonHangController::class, 'lichSuMuaHang'])->name('donhang.lichsu');
Route::get('/thanh-toan', [DonHangController::class, 'index']);
Route::post('/thanh-toan', [DonHangController::class, 'thanhtoan']);
Route::post('/thanh-toan/hoadon', [DonHangController::class, 'store']);

// Tài khoản khách hàng
Route::get('/tai-khoan', [ThayDoiTaiKhoanController::class, 'index']);
Route::post('/tai-khoan/sua', [ThayDoiTaiKhoanController::class, 'update']);

// Đánh giá sản phẩm
Route::post('/cua-hang/san-pham={id}/danh-gia', [DanhGiaController::class, 'store'])->name('danhgia');

Route::post(
    '/cua-hang/san-pham/{id}/danh-gia',
    [DanhGiaController::class, 'store']
)->middleware('auth')->name('danhgia.store');


// Giỏ hàng
Route::get('/gio-hang', [GioHangController::class, 'index']);
Route::post('/gio-hang/cap-nhat', [GioHangController::class, 'update']);
Route::get('/gio-hang/xoa/id={id}', [GioHangController::class, 'destroy']);
Route::get('/cua-hang/san-pham={id}/them', [GioHangController::class, 'themvaogiohang'])->name('them-vao-gio-hang');

// Lấy số lượng theo size
Route::get('/lay-so-luong/{id_giay}/{size}', [ChiTietGiayController::class, 'laySoLuong']);

// Chi tiết sản phẩm
Route::get('/cua-hang/san-pham/id/{id}', [GiayController::class, 'showChiTietSanPham'])->where('id', '[0-9]+');
Route::get('/chi-tiet-san-pham/{id}', [ChiTietSanPhamController::class, 'show'])->name('sanpham.chitiet');

// ----------------- AUTH -----------------
Route::get('/auth/login', [MainController::class, 'login'])->name('auth.login');
Route::get('/auth/register', [MainController::class, 'register'])->name('auth.register');
Route::post('/auth/save', [MainController::class, 'storeReg'])->name('registerStore');
Route::get('/auth/logoff', [MainController::class, 'dangXuat'])->name('auth.logoff');
Route::post('/', [MainController::class, 'loginCheck'])->name('app.dashboard');

// ----------------- ADMIN ----------------- 
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Quản lý tài khoản
Route::get('/admin/taikhoan/taikhoan', [MainController::class, 'show']);
Route::post('/admin/taikhoan/them', [MainController::class, 'store']);
Route::get('/admin/taikhoan/xoa/id={id}', [MainController::class, 'destroy']);
Route::get('/admin/taikhoan/sua/id={id}', [MainController::class, 'edit']);
Route::post('/admin/taikhoan/sua', [MainController::class, 'update']);

// Thương hiệu
Route::get('/admin/thuonghieu/thuonghieu', [ThuongHieuController::class, 'show']);
Route::post('/admin/thuonghieu/them', [ThuongHieuController::class, 'store']);
Route::get('/admin/thuonghieu/xoa/id={id}', [ThuongHieuController::class, 'destroy']);
Route::get('/admin/thuonghieu/sua/id={id}', [ThuongHieuController::class, 'edit']);
Route::post('/admin/thuonghieu/sua', [ThuongHieuController::class, 'update']);

// Loại giày
Route::get('/admin/loaigiay/loaigiay', [LoaiGiayController::class, 'show']);
Route::post('/admin/loaigiay/them', [LoaiGiayController::class, 'store']);
Route::get('/admin/loaigiay/xoa/id={id}', [LoaiGiayController::class, 'destroy']);
Route::get('/admin/loaigiay/sua/id={id}', [LoaiGiayController::class, 'edit']);
Route::post('/admin/loaigiay/sua', [LoaiGiayController::class, 'update']);

// Giày
Route::get('/admin/giay/giay', [GiayController::class, 'show']);
Route::post('/admin/giay/them', [GiayController::class, 'store']);
Route::get('/admin/giay/xoa/id={id}', [GiayController::class, 'destroy']);
Route::get('/admin/giay/sua/id={id}', [GiayController::class, 'edit']);
Route::post('/admin/giay/sua', [GiayController::class, 'update']);

// Khuyến mãi
Route::get('/admin/khuyenmai/khuyenmai', [KhuyenMaiController::class, 'show']);
Route::post('/admin/khuyenmai/them', [KhuyenMaiController::class, 'store']);
Route::get('/admin/khuyenmai/xoa/id={id}', [KhuyenMaiController::class, 'destroy']);
Route::get('/admin/khuyenmai/sua/id={id}', [KhuyenMaiController::class, 'edit']);
Route::post('/admin/khuyenmai/sua', [KhuyenMaiController::class, 'update']);

// Phân quyền
Route::get('/admin/phanquyen/phanquyen', [PhanQuyenController::class, 'show']);
Route::post('/admin/phanquyen/them', [PhanQuyenController::class, 'store']);
Route::get('/admin/phanquyen/xoa/id={id}', [PhanQuyenController::class, 'destroy']);
Route::get('/admin/phanquyen/sua/id={id}', [PhanQuyenController::class, 'edit']);
Route::post('/admin/phanquyen/sua', [PhanQuyenController::class, 'update']);

// Đơn hàng
Route::get('/admin/donhang/donhang', [DonHangController::class, 'show']);
Route::get('/admin/donhang/xoa/id={id}', [DonHangController::class, 'destroy']);
Route::get('/admin/donhang/xem/{id}', [DonHangController::class, 'show']);
Route::post('/admin/donhang/update/{id}', [DonHangController::class, 'updateStatus'])->name('admin.donhang.updateStatus');

// Thống kê
Route::get('/admin/thongke/thongke', [ThongKeController::class, 'thongKe'])->name('admin.thongke.thongke');

// Tồn kho
Route::get('/admin/tonkho', [TonKhoController::class, 'index'])->name('admin.tonkho.index');
Route::post('/admin/tonkho/nhap-them', [TonKhoController::class, 'nhapThem'])->name('tonkho.nhapThem');

// Thêm chi tiết giày
Route::get('/admin/them-chitiet-giay/{id}', [ChiTietGiayController::class, 'create']);

// ----------------- COMMENTS & CONTACT -----------------
Route::get('/comment', [CommentController::class, 'index'])->name('comments.index');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/contact/inquiries', [ContactInquiryController::class, 'showInquiries'])->name('contact.inquiries');
Route::delete('/inquiries/{inquiry}', [ContactInquiryController::class, 'destroy'])->name('inquiries.destroy');
Route::get('/contact', [ContactInfoController::class, 'index'])->name('contact.index');
Route::put('/contact', [ContactInfoController::class, 'update'])->name('contact.update');

// ----------------- WILDCARD CUỐI CÙNG -----------------
Route::get('/admin/{slug}/{slug2}', [AdminController::class, 'dieuhuong2']);
Route::get('/admin/{slug}', [AdminController::class, 'dieuhuong']);
