<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePembayaranProyek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_proyek', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_pembayaran');
            $table->bigInteger('nominal');
            $table->string('nama_pembayaran');
            $table->text('keterangan_pembayaran');
            $table->text('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_proyek');
    }
}
