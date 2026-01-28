@extends('app.app.app')

@section('content')

    <div class="card mb-3 shadow-5" style="background-color: #EEEEEE">
        <div class="card-body" style="margin-top:40px">
            <center>
                <h3 class="card-title" style="text-transform: uppercase;">SẢN PHẨM {{ $giay['ten_giay'] }}</h3>
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
                <li class="breadcrumb-item"><a href="/cua-hang">Cửa hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $giay['ten_giay'] }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/storage/images/{{ $giay['hinh_anh_1'] }}" alt="..." class="img-fluid rounded-start" />
                        {{-- style="height: 432px" --}}
                        <div class="row ">
                            @if ($giay['hinh_anh_2'])
                                <div class="col border ripple"><img src="/storage/images/{{ $giay['hinh_anh_2'] }}"
                                        alt="..." class="img-fluid rounded-start" /></div>
                            @else <div class="col border ripple"><img src="/storage/images/{{ $giay['hinh_anh_1'] }}"
                                        alt="..." class="img-fluid rounded-start" /></div>
                            @endif
                            @if ($giay['hinh_anh_3'])
                                <div class="col ripple"><img src="/storage/images/{{ $giay['hinh_anh_3'] }}" alt="..."
                                        class="img-fluid rounded-start" /></div>
                            @else <div class="col ripple"><img src="/storage/images/{{ $giay['hinh_anh_1'] }}"
                                        alt="..." class="img-fluid rounded-start" /></div>
                            @endif
                            @if ($giay['hinh_anh_4'])
                                <div class="col ripple"><img src="/storage/images/{{ $giay['hinh_anh_4'] }}" alt="..."
                                        class="img-fluid rounded-start" /></div>
                            @else <div class="col ripple"><img src="/storage/images/{{ $giay['hinh_anh_1'] }}"
                                        alt="..." class="img-fluid rounded-start" /></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="float-end">
                                <script>
                                    $(function() {
                                        if ($.fn.rateYo && $("#RateDanhGia").length) {
                                            $("#RateDanhGia").rateYo({
                                                starWidth: "20px",
                                                ratedFill: "#16B5EA",
                                                rating: {{ $soluongdanhgia['danh_gia'] ?? 0 }},
                                                readOnly: true,
                                            });
                                        }
                                    });
                                </script>

                                <small class="text-muted float-end">( {{ $soluongdanhgia['count_danh_gia'] }} Đánh giá
                                    )</small>
                                <div id="RateDanhGia" class="float-end text-info"></div>
                            </div>
                            <h3 class="card-title" style="text-transform: uppercase;">{{ $giay['ten_giay'] }}</h3>

                            <h4 class="card-text text-success">
                                @if ($km = 0)@endif
                                @foreach ($khuyenmais as $khuyenmai)
                                    @if ($khuyenmai['ten_khuyen_mai'] == $giay['ten_khuyen_mai'])
                                        @php $km = sprintf('%d', $giay['don_gia'] * 0.01 * $khuyenmai['gia_tri_khuyen_mai']) @endphp
                                        @if ($gtkm = $khuyenmai['gia_tri_khuyen_mai'])@endif
                                    @endif
                                @endforeach

                                <b>{{ number_format($giay['don_gia'] - $km, 0, ',', ',') }} VNĐ</b>
                                @if ($km != 0)<del class="card-text text-danger">{{ number_format($giay['don_gia'], 0, ',', ',') }} VNĐ</del>@endif
                            </h4>

                            <br>
                            <p class="card-text"><b>Mô tả:</b>{!! $giay['mo_ta'] !!}</p>
                            <p class="card-text"><b>Loại giày:</b> {{ $giay['ten_loai_giay'] }}&emsp;<i
                                    class="fab fa-squarespace"></i>&emsp; <b>Thương hiệu:</b>
                                {{ $giay['ten_thuong_hieu'] }}
                            </p>

                            <p class="card-text">
                                <small class="text-muted"></small>
                            </p>

                            <!-- Thông tin tồn kho -->
                            <!-- <pre>{{ json_encode($giay->chitiet, JSON_PRETTY_PRINT) }}</pre> -->
                            @php
$tong_so_luong = 0;
foreach ($giay->chitiet as $ct) {
    $tong_so_luong += $ct->so_luong;
}
@endphp
    <!-- $tong_so_luong = ($giay->chitiet ?? collect())->sum('so_luong');
@endphp -->
<!-- xemdata -->
<!-- <pre>{{ json_encode($giay->chitiet, JSON_PRETTY_PRINT) }}</pre>
<pre>Tổng số lượng: {{ $tong_so_luong }}</pre> -->

<p class="card-text">
    <b>Tình trạng: </b>
    @if($tong_so_luong > 0)
        <span class="text-success"><i class="fas fa-check-circle"></i> Còn hàng ({{ $tong_so_luong }} sản phẩm)</span>
    @else
        <span class="text-danger"><i class="fas fa-times-circle"></i> Hết hàng</span>
    @endif
</p>

<!-- Form thêm vào giỏ hàng: cho phép nhập số lượng -->
<form action="/cua-hang/san-pham={{ $giay->id_giay }}/them" method="POST" id="addToCartForm">
    @csrf
    @if(!empty($giay->sizes))
        <div class="mb-3">
            <label for="shoe_size" class="form-label"><b>Chọn Size:</b></label>
            <div class="d-flex flex-wrap gap-2">
                @foreach(explode(',', $giay->sizes) as $size)
                    <input type="radio" class="btn-check" name="size" id="size-{{ $size }}" value="{{ trim($size) }}" autocomplete="off" required>
                    <label class="btn btn-outline-primary" for="size-{{ $size }}">{{ trim($size) }}</label>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Hiển thị tồn kho theo size -->
    @php
    // Tạo mảng tồn kho theo size để JS dùng
    $tonkhoBySize = [];
    foreach ($giay->chitiet as $ct) {
        $tonkhoBySize[$ct->size] = $ct->so_luong;
    }
@endphp

<div class="mb-3">
    <label class="form-label"><b>Số lượng còn:</b></label>
    <span id="so_luong_hien_tai" class="text-muted">Vui lòng chọn size</span>
</div>

<div class="mb-3">
    <label class="form-label"><b>Số lượng mua:</b></label>
    <div style="width:120px">
        <input id="so_luong_mua" name="so_luong" type="number" min="1" value="1" class="form-control" />
    </div>
</div>

<script>
    var tonKhoData = @json($tonkhoBySize);

    $(document).ready(function () {
        $('input[name="size"]').on('change', function () {
            let size = $(this).val();
            let soLuong = tonKhoData[size] ?? 0;

            if (soLuong > 0) {
                $('#so_luong_hien_tai')
                    .removeClass('text-muted text-danger')
                    .addClass('text-success')
                    .text(soLuong + ' sản phẩm');
                // cập nhật max cho input số lượng mua
                $('#so_luong_mua').attr('max', soLuong);
                if (parseInt($('#so_luong_mua').val()) > soLuong) {
                    $('#so_luong_mua').val(soLuong);
                }
            } else {
                $('#so_luong_hien_tai')
                    .removeClass('text-success text-muted')
                    .addClass('text-danger')
                    .text('Hết hàng');
                $('#so_luong_mua').attr('max', 0);
                $('#so_luong_mua').val(0);
            }
        });
    });
</script>


    @if($tong_so_luong > 0)
        <button type="submit" class="btn btn-info" style="margin-top: 10px">
            <i class="far fa-heart"></i>
            &ensp;Thêm vào giỏ hàng
        </button>
    @else
        <button type="button" class="btn btn-secondary" style="margin-top: 10px" disabled>
            <i class="fas fa-times"></i>
            &ensp;Hết hàng
        </button>
    @endif
    <a type="button" href="#ex2-tabs-1" class="btn btn-light" style="margin-top: 10px">Chi tiết</a>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('input[name="size"]').on('change', function () {
            let size = $(this).val();
            let id_giay = {{ $giay['id_giay'] }};

            if (size) {
                $.ajax({
                    url: `/lay-so-luong/${id_giay}/${size}`,
                    type: 'GET',
                    success: function (data) {
                        if (data.so_luong > 0) {
                            $('#so_luong_hien_tai')
                                .removeClass('text-muted text-danger')
                                .addClass('text-success')
                                .text(data.so_luong + ' sản phẩm');
                        } else {
                            $('#so_luong_hien_tai')
                                .removeClass('text-success text-muted')
                                .addClass('text-danger')
                                .text('Hết hàng');
                        }
                    }
                });
            }
        });
    });
</script>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="card mb-3">
                <!-- Tabs navs -->
                <div class="container">
                    <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="ex2-tab-1" data-mdb-toggle="tab" href="#ex2-tabs-1" role="tab"
                                aria-controls="ex2-tabs-1" aria-selected="true">Mô tả sản phẩm</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-2" data-mdb-toggle="tab" href="#ex2-tabs-2" role="tab"
                                aria-controls="ex2-tabs-2" aria-selected="false">Chi tiết sản phẩm</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-3" data-mdb-toggle="tab" href="#ex2-tabs-3" role="tab"
                                aria-controls="ex2-tabs-3" aria-selected="false">Đánh giá</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="ex2-content">
                        <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                            <br>
                            {!! $giay['mo_ta'] !!}<br>
                            <p><b>Ngày ra mắt: </b>Ngày 11 tháng 1 năm 2026</p>
                            <p><b>Thiết kế: </b>Yeezy 350</p>
                            <p><b>Mã sản phẩm: </b>{{ $giay['id_giay'] }}</p>
                            <br>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                            <br>
                            <p>✔️ <b>Mã giày: </b>{{ $giay['id_giay'] }}</p>
                            <p>✔️ <b>Tên giày: </b>{{ $giay['ten_giay'] }}</p>
                            <p>✔️ <b>Loại giày: </b>{{ $giay['ten_loai_giay'] }}</p>
                            <p>✔️ <b>Thương hiệu: </b>{{ $giay['ten_thuong_hieu'] }}</p>
                            <p>✔️ <b>Giá gốc: </b>{{ number_format($giay['don_gia']) }} VNĐ</p>
                            <!-- <p>✔️ <b>Số lượng còn lại: </b>{{ $giay['so_luong'] }}</p> -->
                            <p>✔️ <b>Khuyến mãi: </b>{{ $giay['ten_khuyen_mai'] }} (-{{ $gtkm }}%)</p>
                            <p>✔️ <b>Đánh giá: </b>{{ $giay['danh_gia'] }}</p>
                            <p>✔️ <b>Tổng tồn kho: </b>{{ $tong_so_luong }}</p>
<!-- @if($giay->chitiet->count())
    <p>✔️ <b>Chi tiết tồn kho:</b></p>
    <ul>
        @foreach($giay->chitiet as $ct)
            <li>Size: {{ $ct->size }} - Số lượng: {{ $ct->so_luong }}</li>
        @endforeach
    </ul>
@endif -->


                            <br>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-3" role="tabpanel" aria-labelledby="ex2-tab-3">
                            @php
                                $checkk = 0;
                            @endphp


                            <div class="row">

                                <div class="col-md-6">
                                    <br>
                                    <h5 class="card-title" style="margin-bottom:20px">ĐÁNH GIÁ</h5>

                                    @foreach ($danhgias as $danhgia)
                                        @if ($danhgia->id_user > 4)
                                            @php
                                                $ok = rand(1, 4);
                                            @endphp
                                        @else
                                            @php
                                                $ok = $danhgia->id_user;
                                            @endphp
                                        @endif

                                        <div class="row">
                                            <div class="col-1">
                                                <img class="img-profile rounded-circle" height="40" width="40"
                                                    src="/images1/logo-user-{{ $ok-1 }}.png">
                                            </div>
                                            <div class="col-10">
                                                <small>{{ $danhgia->ten_danh_gia }}</small>
                                                <small class="float-end">{{ $danhgia->updated_at }}</small>
                                                <br>
                                                <p>{{ $danhgia->danh_gia_binh_luan }}</p>
                                            </div>
                                        </div>

                                    @endforeach

                                    <div class="pagination pagination-circle justify-content-end">
                                        <center>{{ $danhgias->links() }}</center>
                                    </div>

                                    {{-- <div id="fb-root"></div>
                                            <div class="fb-comments"
                                                data-href="https://dxdbloger.000webhostapp.com?act=detail&id=3"
                                                data-width="" data-numposts="5"></div> --}}
                                </div>
                                @foreach ($danh_gias as $id => $danh_gia)
                                    @if ($danh_gia['ten_giay'] == $giay['ten_giay'])
                                        @php $checkk = 1; @endphp
                                    @endif
                                @endforeach
                                {{-- <center> --}}
                                @if ($checkk == 1)
                                    <div class="col-md-6">
                                        <br>
                                        <h5 class="float-start">ĐÁNH GIÁ SẢN PHẨM NÀY</h5>

                                        <div class="clearfix"></div>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span><b>Chọn số sao:</b></span>
                                            <div id="rateYo" class="text-info" style="display:inline-block;"></div>
                                            <div id="rateFallback" style="display:none;">
                                                <div class="rating-fallback" aria-label="Chọn số sao">
                                                    <input type="radio" id="star5" name="rating_fallback" value="5">
                                                    <label for="star5" title="5 sao">★</label>
                                                    <input type="radio" id="star4" name="rating_fallback" value="4">
                                                    <label for="star4" title="4 sao">★</label>
                                                    <input type="radio" id="star3" name="rating_fallback" value="3">
                                                    <label for="star3" title="3 sao">★</label>
                                                    <input type="radio" id="star2" name="rating_fallback" value="2">
                                                    <label for="star2" title="2 sao">★</label>
                                                    <input type="radio" id="star1" name="rating_fallback" value="1">
                                                    <label for="star1" title="1 sao">★</label>
                                                </div>
                                            </div>
                                        </div>

                                        <style>
                                            .rating-fallback {
                                                display: inline-flex;
                                                flex-direction: row-reverse;
                                                gap: 2px;
                                                line-height: 1;
                                            }
                                            .rating-fallback input { display: none; }
                                            .rating-fallback label {
                                                font-size: 28px;
                                                color: #cfd8dc;
                                                cursor: pointer;
                                                user-select: none;
                                            }
                                            .rating-fallback input:checked ~ label,
                                            .rating-fallback label:hover,
                                            .rating-fallback label:hover ~ label {
                                                color: #16B5EA;
                                            }
                                        </style>

                                        <script>
                                            (function() {
                                                function initRateYoInput() {
                                                    if (!window.jQuery) return;
                                                    var $el = $("#rateYo");
                                                    var $fallback = $("#rateFallback");
                                                    if (!$el.length) return;

                                                    
                                                    if (!$.fn.rateYo) {
                                                        $el.hide();
                                                        $fallback.show();
                                                        $fallback.find("input[name='rating_fallback']").off('change').on('change', function() {
                                                            $('#danh_gia').val($(this).val());
                                                        });
                                                        return;
                                                    }

                                                    
                                                    if ($el.data("rateyo")) return;

                                                    $el.rateYo({
                                                        starWidth: "30px",
                                                        rating: 0,
                                                        fullStar: false,
                                                        multiColor: {
                                                            startColor: "#b0e4f5",
                                                            endColor: "#16B5EA"
                                                        }
                                                    }).on("rateyo.set", function(e, data) {
                                                        $('#danh_gia').val(data.rating);
                                                    });
                                                }

                                                $(initRateYoInput);

                                                document.addEventListener('shown.mdb.tab', initRateYoInput);
                                                document.addEventListener('shown.bs.tab', initRateYoInput);
                                            })();
                                        </script>

                                        <form action="/cua-hang/san-pham={{ $giay['id_giay'] }}/danh-gia" method="POST">
                                            @csrf
                                            <input type="hidden" class="form-control" name="danh_gia" id="danh_gia"
                                                value="0">
                                            <input type="hidden" class="form-control" name="id_user"
                                                value="{{ $data['id'] }}">
                                            <input type="hidden" class="form-control" name="id_giay"
                                                value="{{ $giay['id_giay'] }}">

                                            <div class="form-outline mb-4">
                                                <input type="input" class="form-control" name="ten_danh_gia" required
                                                    value="{{ $data['ten_nguoi_dung'] }}" />
                                                <label class="form-label">Tên</label>
                                            </div>
                                            <div class="form-outline">
                                                <textarea class="form-control" name="danh_gia_binh_luan"
                                                    rows="4"></textarea>
                                                <label class="form-label">Bình luận đánh giá</label>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-info float-end">Gửi đánh giá</button>
                                        </form>

                                    </div>
                                @endif
                                {{-- </center> --}}

                                @if ($checkk == 0)
                                    <div class="col-md-6">
                                        <br><br>
                                        <center>
                                            <p class="text-danger">Bạn cần mua sản phẩm này mới có thể đánh giá!</p>
                                        </center>
                                        <br>
                                    </div>
                                @endif

                            </div>
                            <br>



                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <br>
        <div class="card mb-3 shadow-1">
            <div class="card-body" style="margin-top:40px">
                <center>
                    <h3 class="card-title" style="text-transform: uppercase;">SẢN PHẨM TƯƠNG TỰ</h3>
                </center>
            </div>
            <br>
        </div>
        <br>
        <div id="carouselExampleControls" class="carousel slide" data-mdb-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        @if ($dem = 1)@endif
                        @foreach ($giaytuongtus as $giaytuongtu)
                            @if ($dem < 5)
                                <div class="col-md-3">
                                    <div class="card" style="margin-bottom: 25px">
                                        <a href="/cua-hang/san-pham={{ $giaytuongtu->id_giay }}">
                                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                <center><img src="/storage/images/{{ $giaytuongtu->hinh_anh_1 }}"
                                                        class="img-fluid" style="height:306px; width:306px" /></center>
                                                <div class="mask"
                                                    style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </div>
                                            <div class="card-body">
                                                <center>
                                                    <h4 class="card-title">{{ $giaytuongtu->ten_giay }}</h4>
                                                    <p class="card-text text-success">
                                                        @if ($km = 0)@endif
                                                        @foreach ($khuyenmais as $khuyenmai)
                                                            @if ($khuyenmai['ten_khuyen_mai'] == $giaytuongtu->ten_khuyen_mai)
                                                                @if ($km = sprintf('%d', $giaytuongtu->don_gia * 0.01 * $khuyenmai['gia_tri_khuyen_mai']))@endif
                                                            @endif
                                                        @endforeach

                                                        <b>{{ number_format($giaytuongtu->don_gia - $km, 0, ',', ',') }}
                                                            VNĐ</b>
                                                        <del class="card-text text-danger">{{ number_format($giaytuongtu->don_gia, 0, ',', ',') }}
                                                            VNĐ </del>
                                                    </p>
                                                </center>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @if ($dem = $dem + 1)@endif
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        @if ($dem = 1)@endif
                        @foreach ($giaytuongtus as $giaytuongtu)
                            @if ($dem < 5 && $giaytuongtu->id_giay > 5)
                                <div class="col-md-3">
                                    <div class="card" style="margin-bottom: 25px">
                                        <a href="/cua-hang/san-pham={{ $giaytuongtu->id_giay }}">
                                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                <center><img src="/storage/images/{{ $giaytuongtu->hinh_anh_1 }}"
                                                        class="img-fluid" style="height:306px; width:306px" />
                                                </center>
                                                <div class="mask"
                                                    style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </div>
                                            <div class="card-body">
                                                <center>
                                                    <h4 class="card-title">{{ $giaytuongtu->ten_giay }}</h4>
                                                    <p class="card-text text-success">
                                                        @if ($km = 0)@endif
                                                        @foreach ($khuyenmais as $khuyenmai)
                                                            @if ($khuyenmai['ten_khuyen_mai'] == $giaytuongtu->ten_khuyen_mai)
                                                                @if ($km = sprintf('%d', $giaytuongtu->don_gia * 0.01 * $khuyenmai['gia_tri_khuyen_mai']))@endif
                                                            @endif
                                                        @endforeach

                                                        <b>{{ number_format($giaytuongtu->don_gia - $km, 0, ',', ',') }}
                                                            VNĐ</b>
                                                        <del class="card-text text-danger">{{ number_format($giaytuongtu->don_gia, 0, ',', ',') }}
                                                            VNĐ </del>
                                                    </p>
                                                </center>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @if ($dem = $dem + 1)@endif
                            @endif
                        @endforeach

                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        @if ($dem = 1)@endif
                        @foreach ($giaytuongtus as $giaytuongtu)
                            @if ($dem < 5 && $giaytuongtu->id_giay > 9)
                                <div class="col-md-3">
                                    <div class="card" style="margin-bottom: 25px">
                                        <a href="/cua-hang/san-pham={{ $giaytuongtu->id_giay }}">
                                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                <center><img src="/storage/images/{{ $giaytuongtu->hinh_anh_1 }}"
                                                        class="img-fluid" style="height:306px; width:306px" />
                                                </center>
                                                <div class="mask"
                                                    style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </div>
                                            <div class="card-body">
                                                <center>
                                                    <h4 class="card-title">{{ $giaytuongtu->ten_giay }}</h4>
                                                    <p class="card-text text-success">
                                                        @if ($km = 0)@endif
                                                        @foreach ($khuyenmais as $khuyenmai)
                                                            @if ($khuyenmai['ten_khuyen_mai'] == $giaytuongtu->ten_khuyen_mai)
                                                                @if ($km = sprintf('%d', $giaytuongtu->don_gia * 0.01 * $khuyenmai['gia_tri_khuyen_mai']))@endif
                                                            @endif
                                                        @endforeach

                                                        <b>{{ number_format($giaytuongtu->don_gia - $km) }} VNĐ</b>
                                                        <del class="card-text text-danger">{{ number_format($giaytuongtu->don_gia) }}
                                                            VNĐ </del>
                                                    </p>
                                                </center>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @if ($dem = $dem + 1)@endif
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleControls"
                data-mdb-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleControls"
                data-mdb-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>


    </div>

    <br>

@endsection
