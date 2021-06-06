<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToPembayaranProyek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran_proyek', function (Blueprint $table) {
            $table->unsignedBigInteger('proyek_id')->after('id');
            $table->foreign('proyek_id')->references('id')->on('proyek')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran_proyek', function (Blueprint $table) {
            //
        });
    }
}
