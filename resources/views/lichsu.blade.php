<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>TuanPhuShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL('images1/icon-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container mt-3">
    <a href="/" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left-circle text-danger"></i> Trở về trang chủ
    </a>
</div>

<div class="container mt-5">
<h3 class="text-center fw-bold mb-4 fs-1">
    <i class="bi bi-cart fs-1 me-2"></i> Lịch sử mua hàng
</h3>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">Mã đơn</th>
                        <th class="text-center">Tên người nhận</th>
                        <th class="text-center">Ngày giờ đặt</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($donhangs as $donhang)
                    <tr>
                        <td class="text-center fw-bold">#{{ $donhang->id_don_hang }}</td>
                        <td class="text-center fw-bold">{{ $donhang->ten_nguoi_nhan }}</td>
                        <td class="text-center">{{ $donhang->created_at ? $donhang->created_at->format('d/m/Y H:i') : '' }}</td>
                        <td class="text-center">{{ $donhang->trang_thai ?? 'Chờ duyệt' }}</td>
                        <td class="text-center">
                            <button 
                                class="btn btn-sm btn-outline-primary shadow-sm fw-bold"
                                data-bs-toggle="modal"
                                data-bs-target="#modalChiTietDonHang{{ $donhang->id_don_hang }}"
                            >
                                Xem
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-bag-x fs-3"></i><br>
                            Bạn chưa có đơn hàng nào.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@foreach($donhangs as $donhang)
<div class="modal fade" id="modalChiTietDonHang{{ $donhang->id_don_hang }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Chi tiết đơn hàng #{{ $donhang->id_don_hang }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <p><strong>Tên người nhận:</strong> {{ $donhang->ten_nguoi_nhan }}</p>
        <p><strong>Số điện thoại:</strong> {{ $donhang->sdt }}</p>
        <p><strong>Địa chỉ nhận:</strong> {{ $donhang->dia_chi_nhan }}</p>
        <p><strong>Hình thức thanh toán:</strong> {{ $donhang->hinh_thuc_thanh_toan ?? 'Tiền mặt' }}</p>
        <p><strong>Ghi chú:</strong> {{ $donhang->ghi_chu ?? '-' }}</p>
        <hr>
        <h5 class="fw-bold mb-3">Danh sách sản phẩm</h5>
        <table class="table table-bordered align-middle">
          <thead>
            <tr class="table-secondary">
              <th>Hình ảnh</th>
              <th>Tên sản phẩm</th>
              <th class="text-center">Size</th>
              <th class="text-center">Số lượng mua</th>
            </tr>
          </thead>
          <tbody>
@foreach($donhang->chitietDonHang as $ct)
<tr>
  <td class="text-center">
    <img src="{{ asset('storage/images/' . ($ct->chitietGiay->giay->hinh_anh_1 ?? 'default.jpg')) }}" 
         width="70" class="rounded shadow-sm" alt="Hình">
  </td>
  <td>{{ $ct->chitietGiay->giay->ten_giay ?? '-' }}</td>
  <td class="text-center">{{ $ct->chitietGiay->size ?? '-' }}</td>

  <td class="text-center">{{ $ct->so_luong ?? '-' }}</td>

</tr>
@endforeach
</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
