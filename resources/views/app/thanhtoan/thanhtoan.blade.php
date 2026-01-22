<div class="card mb-3 shadow-5" style="background-color: #EEEEEE">
    <div class="card-body" style="margin-top:40px">
        <center>
            <h3 class="card-title">THANH TOÁN</h3>
        </center>
    </div>
    <br>
</div>

<style>
        #success-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fade-in 0.3s ease-out;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

    </style>
    
    <div id="success-popup" style="display: none;">
        <div class="popup-content">
            <h2>🎉 Thanh toán thành công! 🎉</h2>
            <p>Chúc mừng bạn đã hoàn thành thanh toán.</p>
        </div>
    </div>

    @if(session('show_success_popup'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showSuccessPopup();
        });
        </script>
    @endif
    <script>
        function showSuccessPopup() {
            const popup = document.getElementById('success-popup');
            popup.style.display = 'flex'; // Hiển thị popup

            // Tự động ẩn sau 2 giây
            setTimeout(() => {
                popup.style.display = 'none';
            }, 2000);
        }
    </script>

<div class="container">
    <br>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/trang-chu">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>
    <br>

    <!-- Hiển thị thông báo khuyến khích khi giỏ hàng trống -->
    @if(empty($giohangs))
        <div class="alert alert-info" role="alert">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="alert-heading"><i class="fas fa-shopping-cart"></i> Giỏ hàng trống!</h4>
                    <p>Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm mới và thêm vào giỏ hàng để thanh toán.</p>
                    <hr>
                    <a href="/cua-hang" class="btn btn-primary">
                        <i class="fas fa-store"></i> Khám phá sản phẩm
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #007bff;"></i>
                </div>
            </div>
        </div>
    @else
        <!-- Hiển thị form thanh toán khi có sản phẩm trong giỏ hàng -->
        @php
            $tongtien = 0;
        @endphp

        @foreach ($giohangs as $giohang)
            @php
                $tongtien += $giohang['so_luong'] * $giohang['don_gia'] - $giohang['so_luong'] * $giohang['don_gia'] * $giohang['khuyen_mai'] * 0.01;
            @endphp
        @endforeach

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <form action="/thanh-toan/hoadon" method="POST">
                        @csrf
                        <div class="card-header">
                            <h5 class="card-title" style="margin-top: 10px">THÔNG TIN NHẬN HÀNG:</h5>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="bank_code">Hình thức thanh toán:</label>
                                <select name="hinh_thuc_thanh_toan" id="hinh_thuc_thanh_toan" class="form-control">
                                    <option value="Sau khi nhận hàng">Thanh toán khi nhận hàng</option>
                                    <option value="MOMO"> Ví điện tử MOMO</option>                               
                                </select>
                            </div>
                            <br>

                            <div class="form-outline">
                                <input type="text" class="form-control" name="ten_nguoi_nhan"
                                    value="{{ $data['ten_nguoi_dung'] }}" required />
                                <label class="form-label">Tên người nhận</label>
                            </div>
                            <br>
                            <div class="form-outline">
                                <input type="text" class="form-control" name="sdt" value="{{ $data['sdt'] }}" required />
                                <label class="form-label">Số điện thoại</label>
                            </div>
                            <br>

                            <div class="form-outline">
                                <input type="text" class="form-control" name="dia_chi_nhan" required />
                                <label class="form-label">Địa chỉ nhận</label>
                            </div>
                            <br>

                            <div class="form-outline">
                                <textarea type="text" class="form-control" name="ghi_chu"></textarea>
                                <label class="form-label">Ghi chú</label>
                            </div>

                            <input type="hidden" class="form-control" name="tong_tien" value="{{ number_format($tongtien) }} VNĐ" />
                           
                            <input type="hidden" name="thanh_toans" value="{{ serialize($giohangs) }}" />

                            <br>
                            <button type="submit" class="btn btn-success btn-block">Thanh Toán</button>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title" style="margin-top: 10px">HÓA ĐƠN:</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($giohangs as $giohang)
                                    <tr>
                                        <td scope="row">
                                            {{ $giohang['ten_giay'] }}
                                            @if(!empty($giohang['size']))
                                                <span class="badge bg-primary ms-2">{{ $giohang['size'] }}</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($km = sprintf('%d', $giohang['so_luong'] * $giohang['don_gia'] - $giohang['so_luong'] * $giohang['don_gia'] * $giohang['khuyen_mai'] * 0.01)) }}
                                            VNĐ</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <th scope="row">Phí vận chuyển</th>
                                    <th>32,000 VNĐ</th>
                                </tr>

                                <tr class="text-success  ">
                                    <th scope="row">Tổng </th>
                                    <th>{{ number_format($tongtien + 32000) }} VNĐ</th>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <br>
    <br>
    <br>


</div>
