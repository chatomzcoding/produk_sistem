<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToManajemenLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manajemen_layanan', function (Blueprint $table) {
            $table->unsignedBigInteger('layanan_id')->after('id');
            $table->foreign('layanan_id')->references('id')->on('layanan')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->after('layanan_id');
            $table->foreign('client_id')->references('id')->on('client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manajemen_layanan', function (Blueprint $table) {
            //
        });
    }
}
