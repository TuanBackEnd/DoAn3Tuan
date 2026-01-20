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
                        <div class="row row-sm">


                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h4 class="" style="margin-top: 10px">
                                        <strong>THÊM GIÀY</strong>&ensp;
                                        <i class="fas fa-list"></i>
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <form action="/admin/giay/them" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <br>

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Tên giày</label>
                                                <input type="input" class="form-control" name="ten_giay" required />
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Loại giày</label>
                                                <input type="input" class="form-control" name="ten_loai_giay"
                                                    list="loai_giay" autocomplete="off" required />
                                                <datalist id="loai_giay">
                                                    @foreach ($loaigiays as $loaigiay)
                                                        <option value="{{$loaigiay['ten_loai_giay']}}">
                                                    @endforeach
                                                </datalist>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Thương hiệu</label>
                                                <input type="input" class="form-control" name="ten_thuong_hieu"
                                                    list="thuong_hieu" autocomplete="off" required />
                                                <datalist id="thuong_hieu">
                                                    @foreach ($thuonghieus as $thuonghieu)
                                                        <option value="{{$thuonghieu['ten_thuong_hieu']}}">
                                                    @endforeach
                                                </datalist>
                                            </div>

                                            <label class="form-label"><b>Mô tả:</b></label>
                                            <div class="form-outline mb-4">
                                                <textarea type="input" class="form-control" name="mo_ta" style="height:100px"
                                                    autocomplete="off" id="ckediter" /></textarea>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Đơn giá</label>
                                                <input type="input" class="form-control" name="don_gia" required />
                                            </div>
<!-- 
                                            <div class="form-outline mb-4">
                                                <label class="form-label">Số lượng</label>
                                                <input type="number" class="form-control" name="so_luong" required />
                                            </div> -->

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Các Size Giày (cách nhau bằng dấu phẩy)</label>
                                                <input type="text" class="form-control" name="sizes" placeholder="Ví dụ: 39,40,41" />
                                                <small class="form-text text-muted">Nhập các size giày, mỗi size cách nhau bằng một dấu phẩy.</small>
                                            </div>

                                            <label class="form-label"><b>Hình ảnh 1:</b></label>
                                            <div class="form-outline mb-4">
                                                <input type="file" class="form-control" name="hinh_anh_1" />
                                            </div>

                                            <label class="form-label"><b>Hình ảnh 2:</b></label>
                                            <div class="form-outline mb-4">
                                                <input type="file" class="form-control" name="hinh_anh_2" />
                                            </div>

                                            <label class="form-label"><b>Hình ảnh 3:</b></label>
                                            <div class="form-outline mb-4">
                                                <input type="file" class="form-control" name="hinh_anh_3" />
                                            </div>

                                            <label class="form-label"><b>Hình ảnh 4:</b></label>
                                            <div class="form-outline mb-4">
                                                <input type="file" class="form-control" name="hinh_anh_4" />
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label class="form-label">Khuyến mãi</label>
                                                <input type="input" class="form-control" name="ten_khuyen_mai"
                                                    list="khuyen_mai" autocomplete="off" />
                                                <datalist id="khuyen_mai">
                                                    @foreach ($khuyenmais as $khuyenmai)
                                                        <option value="{{$khuyenmai['ten_khuyen_mai']}}">
                                                    @endforeach
                                                </datalist>
                                            </div>

                                            <input type="hidden" class="form-control" name="so_luong_mua" value="0" />

                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                            <a href="/admin/giay" type="button" class="btn btn-info">Quay lại</a>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- CONTAINER CLOSED -->
            @endsection     