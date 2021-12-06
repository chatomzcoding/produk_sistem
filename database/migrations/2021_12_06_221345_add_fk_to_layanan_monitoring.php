<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToLayananMonitoring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layanan_monitoring', function (Blueprint $table) {
            $table->unsignedBigInteger('layanan_id')->after('id');
            $table->foreign('layanan_id')->references('id')->on('layanan')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->after('layanan_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layanan_monitoring', function (Blueprint $table) {
            //
        });
    }
}
