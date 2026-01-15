<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Giay;
use App\Models\LoaiGiay;
use App\Models\ThuongHieu;
use App\Models\KhuyenMai;
use App\Models\GioHang;
use App\Models\PhanQuyen;
use App\Models\DonHang;
use App\Models\ChiTietGiay;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\DB;


class DonHangController extends Controller
{
    public function index()
    {
        if (session()->get('check') == 0) {
            return view('auth.login');
        }

        $data = User::where('id', session('DangNhap'))->first();
        $thuonghieus = ThuongHieu::all();
        $loaigiays = LoaiGiay::all();
        $giays = Giay::all();
        $users = User::all();
        $phanquyens = PhanQuyen::all();
        $khuyenmais = KhuyenMai::all();
        $giohangs = session()->get('gio_hang', []);

        return view('index', [
            'route' => 'thanh-toan',
            'data' => $data,
            'thuonghieus' => $thuonghieus,
            'loaigiays' => $loaigiays,
            'giays' => $giays,
            'users' => $users,
            'phanquyens' => $phanquyens,
            'khuyenmais' => $khuyenmais,
            'giohangs' => $giohangs
        ]);
    }

    public function thanhtoan(Request $request)
    {
        $giohangs = session()->get('gio_hang', []);
        $thanhtoans = [];

        foreach ($request->input('check-gio-hang', []) as $check_gio_hang) {
            if (isset($giohangs[$check_gio_hang])) {
                $thanhtoans[$check_gio_hang] = $giohangs[$check_gio_hang];
            }
        }

        if (session()->get('check') == 0) {
            return view('auth.login');
        }

        $data = User::where('id', session('DangNhap'))->first();
        $thuonghieus = ThuongHieu::all();
        $loaigiays = LoaiGiay::all();
        $giays = Giay::all();
        $users = User::all();
        $phanquyens = PhanQuyen::all();
        $khuyenmais = KhuyenMai::all();

        return view('index', [
            'route' => 'thanh-toan',
            'data' => $data,
            'thuonghieus' => $thuonghieus,
            'loaigiays' => $loaigiays,
            'giays' => $giays,
            'users' => $users,
            'phanquyens' => $phanquyens,
            'khuyenmais' => $khuyenmais,
            'giohangs' => $thanhtoans
        ]);
    }

    public function create()
    {
        //
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function store(Request $request)
    {
        $giohangs = session()->get('gio_hang', []);
        $oks = unserialize($request->input('thanh_toans', 'a:0:{}'));

        if ($request->hinh_thuc_thanh_toan === "MOMO") {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua MoMo";
            $amount = preg_replace('/[^0-9]/', '', $request->tong_tien);
            $orderId = time();
            $requestId = time();
            // $sessionId = session()->getId();
            // $redirectUrl = "http://localhost:8000/thanh-toan?session_id=" . $sessionId;
            // $ipnUrl = $redirectUrl;
            $redirectUrl = "http://localhost:8000/thanh-toan";
            $ipnUrl = $redirectUrl;

            $extraData = "";
            $requestType = "payWithATM";

            $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl"
                . "&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode"
                . "&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => intval($amount),
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];

            $jsonResult = json_decode($this->execPostRequest($endpoint, json_encode($data)), true);

            $donhang = DonHang::create([
                'id_khach_hang' => session('DangNhap'),
                'ten_nguoi_nhan' => $request->input('ten_nguoi_nhan'),
                'sdt' => $request->input('sdt'),
                'dia_chi_nhan' => $request->input('dia_chi_nhan'),
                'ghi_chu' => $request->input('ghi_chu'),
                'tong_tien' => $request->input('tong_tien'),
                'hoa_don' => $request->input('thanh_toans'),
                'hinh_thuc_thanh_toan' => $request->input('hinh_thuc_thanh_toan'),
            ]);
            
            // $this->ChiTietDonHang($donhang->id_don_hang, $oks, $giohangs);
            $this->saveChiTietDonHang($donhang->id_don_hang, $oks, $giohangs);

            $this->processOrderItems($oks, $giohangs);
            return redirect()->to($jsonResult['payUrl']);
        }

        // thanh toán thường
        $donhang = DonHang::create([
            'id_khach_hang' => session('DangNhap'),
            'ten_nguoi_nhan' => $request->input('ten_nguoi_nhan'),
            'sdt' => $request->input('sdt'),
            'dia_chi_nhan' => $request->input('dia_chi_nhan'),
            'ghi_chu' => $request->input('ghi_chu'),
            'tong_tien' => $request->input('tong_tien'),
            'hoa_don' => $request->input('thanh_toans'),
            'hinh_thuc_thanh_toan' => $request->input('hinh_thuc_thanh_toan'),
        ]);

        // $this->ChiTietDonHang($donhang->id_don_hang, $oks, $giohangs);
        $this->saveChiTietDonHang($donhang->id_don_hang, $oks, $giohangs);

        $this->processOrderItems($oks, $giohangs);
        return Redirect('/thanh-toan');
    }

    private function processOrderItems($oks, &$giohangs)
    {
        $danh_gias = session()->get('danh_gias', []);

        foreach ($oks as $id => $ok) {
            $danh_gias[$id] = $ok;
            $giay = Giay::find($id);
            if ($giay) {
                $giay->so_luong_mua += 1;
                $giay->save();
            }
        }

        session()->put('danh_gias', $danh_gias);

        foreach ($danh_gias as $iddg => $danh_gia) {
            unset($giohangs[$iddg]);
        }

        session()->flash('show_success_popup', true);
        session()->put('gio_hang', $giohangs);
    }

    public function show($id)
    {
        $data = User::where('id', session('DangNhap'))->first();
        $thuonghieus = ThuongHieu::all();
        $loaigiays = LoaiGiay::all();
        $giays = Giay::all();
        $users = User::all();
        $phanquyens = PhanQuyen::all();
        $khuyenmais = KhuyenMai::all();
        $donhangId = DonHang::find($id);

        return view('admin.donhang.xem', compact('donhangId', 'data', 'thuonghieus', 'loaigiays', 'giays', 'users', 'phanquyens', 'khuyenmais'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
{
    $donhang = DonHang::find($id);

    if (!$donhang) {
        return redirect('/admin/donhang')->with('error', 'Không tìm thấy đơn hàng.');
    }

    $donhang->trang_thai = $request->input('trang_thai');
    $donhang->save();

    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
}


public function destroy($id)
{
    $data = DonHang::find($id);

    if (!$data) {
        return redirect('/admin/donhang')->with('error', 'Đơn hàng không tồn tại.');
    }

    $data->delete();

    return redirect('/admin/donhang')->with('success', 'Xóa đơn hàng thành công.');
}


    public function lichSuMuaHang()
    {
        $userId = session('DangNhap');
        if (!$userId) {
            return redirect('/auth/login')->with('error', 'Vui lòng đăng nhập để xem lịch sử.');
        }

        $donhangs = DonHang::where('id_khach_hang', $userId)
            ->with('chitietDonHang.chitietGiay.giay')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lichsu', compact('donhangs'));
    }

    public function chitietDonHang()
    {
        $donhangs = DonHang::with('chitietDonHang')->orderBy('created_at', 'desc')->get();
        return view('lichsu', compact('donhangs'));
    }

    

    private function saveChiTietDonHang($idDonHang, $oks, $giohangs)
{

    foreach ($oks as $cartItemId => $item) {
        [$id_giay, $size] = explode('-', $cartItemId);
        $so_luong = $giohangs[$cartItemId]['so_luong'] ?? 1;

        $chiTietGiay = ChiTietGiay::where('id_giay', $id_giay)
                                  ->where('size', $size)
                                  ->first();
                                  
                                  $gia = $giohangs[$cartItemId]['gia'] ?? 0;

                                  if ($chiTietGiay) {
                                    ChiTietDonHang::create([
                                        'id_don_hang' => $idDonHang,
                                        'id_chitiet_giay' => $chiTietGiay->id_chitiet_giay,
                                        'so_luong' => $so_luong,
                                        'gia' => $gia,
                                    ]);
                                
                                    // trừ tồn khi khi đặt tc thì sl sẽ giảm
                                    $chiTietGiay->so_luong -= $so_luong;
                                    if ($chiTietGiay->so_luong < 0) {
                                        $chiTietGiay->so_luong = 0;
                                    }
                                    $chiTietGiay->save();
                                }
                                
        
    }
}




}


