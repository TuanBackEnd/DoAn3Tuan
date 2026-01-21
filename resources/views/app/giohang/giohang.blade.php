@extends('app.app.app')

@section('content')
<div class="card mb-3 shadow-5" style="background-color: #EEEEEE">
    <div class="card-body" style="margin-top:40px">
        <center>
            <h3 class="card-title">GIỎ HÀNG</h3>
        </center>
    </div>
    <br>
</div>

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
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
        </ol>
    </nav>
    
    @if(count($giohangsAll ?? []) > 0)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="badge bg-info">Tổng số sản phẩm: {{ count($giohangsAll) }}</span>
        </div>
        <div>
            <a href="/gio-hang/xoa-tat-ca" onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ sản phẩm trong giỏ hàng?');" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Xóa toàn bộ
            </a>
        </div>
    </div>
    @endif
    
    <br>

    
    <div class="table-responsive">
        <!-- table-hover -->
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tên giày</th>
                    <th scope="col">Size</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Khuyến mãi</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thành tiền</th>
                    <th scope="col">Thay đổi</th>
                </tr>
            </thead>
            <tbody>
                @if(count($giohangs ?? []) > 0)
                @foreach($giohangs as $id=>$giohang)
                <tr>
                    <th>
                        <form id="thanh-toan" action="/thanh-toan" method="POST">
                            @csrf 
                            <div class="form-check info">
                                <input class="form-check-input" type="checkbox" value="{{$id}}" name="check-gio-hang[]" form="thanh-toan" checked/>
                            </div>
                        </form>
                    </th>
                    <td scope="row">
                        @php
                            $imgPath = 'storage/images/' . $giohang['hinh_anh_1'];
                            $imgExists = file_exists(public_path($imgPath)) || file_exists(storage_path('app/public/images/' . $giohang['hinh_anh_1']));
                        @endphp
                        <img src="{{ $imgExists ? asset($imgPath) : asset('images1/logo.png') }}" alt="{{ $giohang['ten_giay'] }}" class="img-fluid rounded-start"
                            width="100px" onerror="this.src='{{ asset('images1/logo.png') }}'" />
                    </td>
                    <td>{{$giohang['ten_giay']}}</td>
                    <td>
                        @php
                            $giay = \App\Models\Giay::find($giohang['id_giay']);
                            $availableSizes = [];
                            if ($giay && !empty($giay->sizes)) {
                                $availableSizes = explode(',', $giay->sizes);
                                $availableSizes = array_map('trim', $availableSizes);
                            } else {
                                // Nếu không có sizes trong database, tạo mảng size mặc định 37-42
                                $availableSizes = ['37', '38', '39', '40', '41', '42'];
                            }
                            $currentSize = $giohang['size'] ?? null;
                            $hetHang = $giohang['het_hang'] ?? false;
                            $soLuongCon = $giohang['so_luong_con'] ?? 0;
                        @endphp
                        
                        @if($hetHang)
                            <span class="badge bg-danger">Size {{ $currentSize }} - Hết hàng</span>
                        @else
                            <select name="size" class="form-select form-select-sm" style="width: auto; display: inline-block;" onchange="updateSize(this, '{{$id}}')">
                                @foreach($availableSizes as $size)
                                    @php
                                        $ctSize = \App\Models\ChiTietGiay::where('id_giay', $giohang['id_giay'])
                                            ->where('size', trim($size))
                                            ->first();
                                        $sizeAvailable = $ctSize && $ctSize->so_luong > 0;
                                    @endphp
                                    <option value="{{ trim($size) }}" 
                                        {{ $currentSize == trim($size) ? 'selected' : '' }}
                                        {{ !$sizeAvailable ? 'disabled' : '' }}>
                                        {{ trim($size) }} {{ !$sizeAvailable ? '(Hết hàng)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @if($soLuongCon > 0)
                                <small class="text-muted d-block">Còn: {{ $soLuongCon }} sản phẩm</small>
                            @endif
                        @endif
                    </td>
                    <td>{{number_format($giohang['don_gia'])}} VNĐ</td>
                    <td>{{$giohang['khuyen_mai']}}%</td>

                    <form action="/gio-hang/cap-nhat" method="POST" id="form-update-{{$id}}">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{$id}}"/>
                        <input type="hidden" class="form-control" name="size" id="size-input-{{$id}}" value="{{$giohang['size'] ?? ''}}"/>

                        <td>
                            @if($hetHang)
                                <span class="text-danger">Hết hàng</span>
                            @else
                                <div class="d-flex">
                                    <div class="btn btn-info px-3 mr-1"
                                        onclick="decreaseQuantity('{{$id}}')" style="margin-right:2px">
                                        <i class="fas fa-minus"></i>
                                    </div>

                                    <div class="form-outline" style="width:80px">
                                        <input id="so_luong-{{$id}}" min="1" max="{{$soLuongCon}}" name="so_luong" value="{{$giohang['so_luong']}}"
                                            type="number" autocomplete="off" class="form-control" />
                                        <label class="form-label" for="so_luong-{{$id}}">Số lượng</label>
                                    </div>&nbsp;

                                    <div class="btn btn-info px-3 mr-1"
                                        onclick="increaseQuantity('{{$id}}', {{$soLuongCon}})">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td><b>{{number_format($km = sprintf('%d', ($giohang['so_luong'] * $giohang['don_gia']) - ($giohang['so_luong'] * $giohang['don_gia'] * $giohang['khuyen_mai'] * 0.01)))}} VNĐ<b>
                        </td>
                        <td>
                            @if(!$hetHang)
                                <button type="submit" class="btn btn-info">Cập nhật</button>
                            @endif
                            <a href="/gio-hang/xoa/id={{$id}}" onclick="return confirm('Bạn có thật sự muốn xóa ?');" type="button"
                                class="btn btn-danger">Xóa</a>
                        </td>
                    </form>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Giỏ hàng của bạn đang trống</p>
                        <a href="/cua-hang" class="btn btn-info">Tiếp tục mua sắm</a>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

    @if(isset($paginator) && $paginator->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $paginator->links() }}
    </div>
    @endif

    <script>
    function updateSize(selectElement, itemId) {
        document.getElementById('size-input-' + itemId).value = selectElement.value;
    }
    
    function decreaseQuantity(itemId) {
        var input = document.getElementById('so_luong-' + itemId);
        var current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }
    
    function increaseQuantity(itemId, maxQuantity) {
        var input = document.getElementById('so_luong-' + itemId);
        var current = parseInt(input.value);
        if (current < maxQuantity) {
            input.value = current + 1;
        } else {
            alert('Số lượng không thể vượt quá tồn kho!');
        }
    }
    
    $(document).ready(function() {
        // Không dùng DataTable nữa vì đã có phân trang thủ công
        // $('#dataTable').DataTable();
    });
    </script>

    <br>
    <br>

    @php
    $tongtien = 0;
    @endphp

    @foreach($giohangsAll ?? $giohangs as $id => $giohang)
    @php
    $tongtien += ($giohang['so_luong'] * $giohang['don_gia']) - ($giohang['so_luong'] * $giohang['don_gia'] * $giohang['khuyen_mai'] * 0.01);
    @endphp
    @endforeach


    <div class="card ">
        <form class="card-header">
            <div class="float-start">
                <h4 class="card-title text-success" style="margin-top: 20px">Tổng tiền:  {{number_format($tongtien)}} VNĐ
                </h4>
            </div>
                <div class="float-end">
                    <button type="submit" class="btn btn-success" style="margin: 15px" form="thanh-toan">Thanh Toán</button>
                </div>
            </div>
        </form>
    </div>
 
    <br>
    <br>

</div>
@endsection