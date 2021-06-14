<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTanggalJobdeskToTableManajemenJobdesk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manajemen_jobdesk', function (Blueprint $table) {
            $table->date('tgl_awal')->nullable();
            $table->date('tgl_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manajemen_jobdesk', function (Blueprint $table) {
            //
        });
    }
}
