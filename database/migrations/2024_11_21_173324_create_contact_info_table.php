<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInfoTable extends Migration
{
    public function up()
    {
        Schema::create('lien_he', function (Blueprint $table) {
            $table->id(); // Trường ID tự tăng
            $table->string('ten_cua_hang'); // Tên cửa hàng
            $table->string('dia_chi'); // Địa chỉ cửa hàng
            $table->string('so_dien_thoai'); // Số điện thoại
            $table->string('email'); // Địa chỉ email
            $table->string('fax')->nullable(); // Fax (có thể để trống)
            $table->string('gio_lam_viec'); // Giờ làm việc
            $table->string('link_mang_xa_hoi')->nullable(); // Liên kết mạng xã hội (có thể để trống)
            $table->text('ban_do')->nullable(); // Mã nhúng Google Maps (có thể để trống)
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('lien_he');
    }
}
