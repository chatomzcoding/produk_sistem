<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToManajemenProyek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manajemen_proyek', function (Blueprint $table) {
            $table->date('tgl_berakhir')->nullable();
            $table->bigInteger('pendapatan')->nullable();
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
