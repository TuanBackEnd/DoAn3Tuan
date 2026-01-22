@extends('admin.index')

@section('admin_content')

            <!--app-content open-->
            <div class="app-content main-content mt-0">
                <div class="side-app">
                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">
                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <div>
                                <h1 class="page-title">Quản Lý Bình Luận</h1>
                            </div>
                        </div>
                        <!-- PAGE-HEADER END -->

                        <!-- Row -->
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="card custom-card">
                                    <div class="card-header border-bottom">
                                        <!-- <h3 class="card-title">Comment Table</h3> -->
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">
                                        Bảng này hiển thị danh sách các bình luận của khách hàng !!!
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
                                                        <th>ID</th>
                                                        <th>Tên Khách Hàng</th> <!-- Tên khách hàng -->
                                                        <th>Sản Phẩm</th> <!-- Tên sản phẩm -->
                                                        <th>Bình Luận</th> <!-- Nội dung bình luận -->
                                                        <th>Đánh giá</th>
                                                        <th>Hành động</th> <!-- Hành động -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($comments as $comment)
                                                    <tr>
                                                        <td>{{ $comment->id_danh_gia }}</td>
                                                        <td>{{ $comment->ten_danh_gia ?? ''}}</td>
                                                        <!-- Tên khách hàng -->
                                                        <td>{{ optional($comment->product)->ten_giay ?? 'N/A' }}</td>

                                                        <!-- Tên sản phẩm -->
                                                        <td>{{ $comment->danh_gia_binh_luan }}</td>
                                                        <td>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fa fa-star {{ $i <= $comment->danh_gia ? 'text-warning' : 'text-muted' }}"></i>
                                                            @endfor
                                                        </td>
                                                        <!-- Nội dung bình luận -->
                                                        <td>
                                                            <!-- Edit Action -->
                                                            <!-- Delete Action -->
                                                            <form action="{{ route('comments.destroy', $comment->id_danh_gia) }}" method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                                                    Xóa
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- CONTAINER CLOSED -->


        <!-- Country-selector modal-->
     @endsection