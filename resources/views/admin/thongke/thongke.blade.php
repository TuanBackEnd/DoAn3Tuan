@extends('admin.index')

@section('admin_content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thống kê sản phẩm bán chạy</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên giày</th>
                <th>ID Chi Tiết Giày</th>
                <th>Tổng số lượng đã bán</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($thongke as $item)
                <tr>
                    <td>{{ $item->ten_giay }}</td>
                    <td>{{ $item->id_chitiet_giay }}</td>
                    <td>{{ $item->da_ban }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
