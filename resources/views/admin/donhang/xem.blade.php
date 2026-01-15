@extends('admin.index')

@section('admin_content')

<!--app-content open-->
<div class="app-content main-content mt-0">
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <!-- PAGE-HEADER -->
            <!-- <div class="page-header">
                <div>
                    <h1 class="page-title">Tables</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">Tables</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Default Table
                        </li>
                    </ol>
                </div>
            </div> -->
            <!-- PAGE-HEADER END -->

            <!-- Row -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="" style="margin-top: 10px">
                        <strong>XEM CHI TIẾT ĐƠN HÀNG</strong>&ensp;
                        <i class="fas fa-cart-arrow-down"></i>
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
    <tr>
        <th scope="col">Tên giày</th>
        <th scope="col">Size</th>
        <th scope="col">Số lượng</th>
        <th scope="col">Thành tiền</th>
        <th scope="col">Tên người nhận</th>
        <th scope="col">Địa chỉ nhận</th>
        <th scope="col">Ghi chú</th>
    </tr>
</thead>
<tbody>
    @php 
        //$donhangs = unserialize($donhangId['hoa_don']);
        $donhangs = unserialize($donhangId->hoa_don);

    @endphp

    @foreach ($donhangs as $donhang)
        <tr>
            <td>{{ $donhang['ten_giay'] }}</td>
            <td>
                @if (!empty($donhang['size']))
                    <span class="badge bg-primary">{{ $donhang['size'] }}</span>
                @else
                    N/A
                @endif
            </td>
            <td>{{ $donhang['so_luong'] }}</td>
            <td>{{ number_format($donhang['don_gia'] * $donhang['so_luong']) }} VNĐ</td>
            <td>{{ $donhangId->ten_nguoi_nhan }}</td>
            <td>{{ $donhangId->dia_chi_nhan }}</td>
            <td>{{ $donhangId->ghi_chu ?? 'Không có' }}</td>
        </tr>
    @endforeach
</tbody>
                        </table>

                        <script>
                            $(document).ready(function () {
                                $('#dataTable').DataTable();
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- TRẠNG THÁI ĐƠN HÀNG -->
            <div class="card-body">
                <div class="mb-3">
                    <strong>Trạng thái đơn hàng:</strong>
                    <span class="badge bg-info">{{ $donhangId->trang_thai }}</span>
                </div>

                <div class="d-flex justify-content-evenly flex-wrap gap-2">
                    @php
                        $statuses = [
                            ['label' => 'Chờ duyệt', 'class' => 'primary', 'icon' => '⏳'],
                            ['label' => 'Đã duyệt', 'class' => 'warning', 'icon' => '✅'],
                            ['label' => 'Đang chuẩn bị hàng', 'class' => 'info', 'icon' => '📦'],
                            ['label' => 'Đang giao hàng', 'class' => 'secondary', 'icon' => '🚚'],
                            ['label' => 'Đã giao', 'class' => 'success', 'icon' => '🎉'],
                            ['label' => 'Đã hủy', 'class' => 'danger', 'icon' => '❌'],
                        ];
                    @endphp

                    @foreach ($statuses as $status)
                        @if ($donhangId->trang_thai == $status['label'])
                            <button type="button" class="btn btn-{{ $status['class'] }}" disabled title="Trạng thái hiện tại">
                                <span>{{ $status['icon'] }}</span> {{ $status['label'] }}
                            </button>
                        @else
                        <form action="{{ route('admin.donhang.updateStatus', $donhangId->id_don_hang) }}" method="POST">
                                @csrf
                                <input type="hidden" name="trang_thai" value="{{ $status['label'] }}">
                                <button type="submit" class="btn btn-{{ $status['class'] }}" title="Chuyển sang {{ strtolower($status['label']) }}">
                                    <span>{{ $status['icon'] }}</span> {{ $status['label'] }}
                                </button>
                            </form>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->

@endsection
