<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserToDonHangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('don_hang', function (Blueprint $table) {
        $table->unsignedBigInteger('id_user')->nullable()->after('id_don_hang');
    });
}

public function down()
{
    Schema::table('don_hang', function (Blueprint $table) {
        $table->dropColumn('id_user');
    });
}

}
