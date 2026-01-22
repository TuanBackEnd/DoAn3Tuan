@extends('admin.index')

@section('admin_content')
            <!--/APP-SIDEBAR-->

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
                                <strong>SỬA LOẠI GIÀY</strong>&ensp;
                                <i class="fas fa-shoe-prints"></i>
                            </h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="/admin/loaigiay/sua" method="POST">
                                    @csrf
                                    <br>
                                    <input type="hidden" class="form-control" name="id_loai_giay" value="{{$loaigiay['id_loai_giay']}}"/>

                                    <div class="form-outline mb-4">
                                        <input type="input" class="form-control" name="ten_loai_giay" value="{{$loaigiay['ten_loai_giay']}}" required/>
                                        <label class="form-label" >Tên loại giày</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                    <a href="/admin/loaigiay" type="button" class="btn btn-info">Quay lại</a>

                                </form>

                            </div>
                        </div>
                    </div>


                         </div>
                        </div>
                   </div>
                                <!-- CONTAINER CLOSED -->
                            </div>

        <!-- Country-selector modal-->
@endsection
        