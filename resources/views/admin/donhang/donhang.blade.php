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
                                    <strong>XÉT DUYỆT ĐƠN HÀNG</strong>&ensp;
                                    <i class="fas fa-cart-arrow-down"></i>
                                </h4>
                            </div>
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- table-hover -->
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Tên người nhận</th>
                                                <th scope="col">Địa chỉ nhận</th>
                                                <th scope="col">Số điện thoại</th>
                                                <th scope="col">Ngày đặt hàng</th>
                                                <th scope="col">Ghi chú</th>
                                                <th scope="col">Tổng tiền</th>
                                                <th scope="col">Trạng thái</th> <!-- Cột Trạng thái -->
                                                <th scope="col">Thay đổi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($donhangs as $donhang)

                                                <tr>
                                                    <td scope="row">{{$donhang['id_don_hang']}}</td>
                                                    <td>{{$donhang['ten_nguoi_nhan']}}</td>
                                                    <td>{{$donhang['dia_chi_nhan']}}</td>
                                                    <td>{{$donhang['sdt']}}</td>
                                                    <td>{{$donhang['created_at']}}</td>
                                                    <td>{{$donhang['ghi_chu']}}</td>
                                                    <td>{{$donhang['tong_tien']}} VNĐ</td>

                                                    <!-- Hiển thị trạng thái -->
                                                    <td>
                                                        @php
                                                            $badgeClass = [
                                                                'Chờ duyệt' => 'primary',
                                                                'Đã duyệt' => 'warning',
                                                                'Đang chuẩn bị hàng' => 'info',
                                                                'Đang giao hàng' => 'secondary',
                                                                'Đã giao' => 'success',
                                                                'Đã hủy' => 'danger',
                                                            ];
                                                            $class = $badgeClass[$donhang['trang_thai']] ?? 'secondary';
                                                        @endphp
                                                        <span class="btn btn-{{ $class }} btn-rounded">{{ $donhang['trang_thai'] }}</span>
                                                    </td>
                                                    <td>
                                                    <a href="{{ url('/admin/donhang/xem/'.$donhang['id_don_hang']) }}"
                                                            type="button" class="btn btn-success btn-rounded">Xem chi tiết</a>

                                                        <a href="/admin/donhang/xoa/id={{$donhang['id_don_hang']}}"
                                                            onclick="return confirm('Bạn có thật sự muốn xóa ?');"
                                                            type="button" class="btn btn-danger btn-rounded">Xóa</a>
                                                    </td>
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
                        <!-- </div>
                            <div class="card shadow">
                                <div class="card-header">
                                    <h5 class="card-title" style="margin-top: 10px">Tùy chỉnh:</h5>
                                </div>
                                <div class="card-body">

                                    <a href="/admin/donhang/them" type="button" class="btn btn-info">Duyệt</a>

                                </div>
                            </div>
                    </div> -->
                </div>
            </div>
            <!-- CONTAINER CLOSED -->

        <!-- Country-selector modal-->
@endsection
    