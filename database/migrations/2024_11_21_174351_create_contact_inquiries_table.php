<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('yeu_cau_khach_hang', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->string('ten'); // Tên người dùng
            $table->string('email'); // Email người dùng
            $table->text('tin_nhan'); // Tin nhắn của người dùng
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('yeu_cau_khach_hang');
    }
}
