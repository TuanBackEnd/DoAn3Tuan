@extends('admin.index')

@section('admin_content')

<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Quản Lý Tồn Kho</h1>
                </div>
            </div>

            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <p class="text-muted">
                                Bảng này hiển thị tồn kho giày theo từng size !!!
                            </p>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID Chi Tiết</th>
                                            <th>Tên Giày</th>
                                            <th>Size</th>
                                            <th>Số Lượng</th>
                                            <th>Nhập Thêm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tonkhos as $tk)
                                            <tr>
                                                <td>{{ $tk->id_chitiet_giay }}</td>
                                                <td>{{ $tk->giay->ten_giay ?? 'N/A' }}</td>
                                                <td>{{ $tk->size }}</td>
                                                <td>{{ $tk->so_luong }}</td>
                                                <td>
                                                    <form action="{{ route('tonkho.nhapThem') }}" method="POST" class="d-flex">
                                                        @csrf
                                                        <input type="hidden" name="id_chitiet_giay" value="{{ $tk->id_chitiet_giay }}">
                                                        <input type="number" name="so_luong_nhap" class="form-control me-2" style="width: 100px;" placeholder="Số lượng" min="1" required>
                                                        <button type="submit" class="btn btn-success btn-sm">Nhập thêm</button>
                                                    </form>
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
