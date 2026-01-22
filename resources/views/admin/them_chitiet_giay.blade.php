@extends('admin.index')

@section('admin_content')
<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Thêm Chi Tiết Giày</h1>
                </div>
            </div>

            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <strong>Thêm Chi Tiết Cho: {{ $giay->ten_giay }}</strong>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5>Chi tiết giày hiện tại:</h5>
                                @if($giay->chitiet && $giay->chitiet->count() > 0)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Size</th>
                                                <th>Số Lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($giay->chitiet as $ct)
                                                <tr>
                                                    <td>{{ $ct->id_chitiet_giay }}</td>
                                                    <td>{{ $ct->size }}</td>
                                                    <td>{{ $ct->so_luong }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">Chưa có chi tiết nào cho giày này.</p>
                                @endif
                            </div>

                            <form action="{{ route('chitietgiay.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_giay" value="{{ $giay->id_giay }}">

                                <div class="form-outline mb-4">
                                    <label class="form-label">Size</label>
                                    <input type="text" class="form-control" name="size" 
                                           placeholder="Ví dụ: 39, 40, 41, 42..." required>
                                    <small class="form-text text-muted">Nhập size giày (ví dụ: 39, 40, 41, 42, S, M, L...)</small>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Số Lượng</label>
                                    <input type="number" class="form-control" name="so_luong" 
                                           min="0" value="0" required>
                                    <small class="form-text text-muted">Nhập số lượng giày có size này</small>
                                </div>

                                <button type="submit" class="btn btn-primary">Thêm Chi Tiết</button>
                                <a href="/admin/giay/giay" class="btn btn-info">Quay lại</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
