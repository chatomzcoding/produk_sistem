<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToManajemenProyek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manajemen_proyek', function (Blueprint $table) {
            $table->unsignedBigInteger('proyek_id')->after('id');
            $table->foreign('proyek_id')->references('id')->on('proyek')->onDelete('cascade');
            $table->unsignedBigInteger('anggota_id')->after('proyek_id');
            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manajemen_proyek', function (Blueprint $table) {
            //
        });
    }
}
