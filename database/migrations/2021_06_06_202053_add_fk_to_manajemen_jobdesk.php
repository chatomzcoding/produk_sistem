<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToManajemenJobdesk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manajemen_jobdesk', function (Blueprint $table) {
            $table->unsignedBigInteger('anggota_id')->after('id');
            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
            $table->unsignedBigInteger('jobdesk_id')->after('anggota_id');
            $table->foreign('jobdesk_id')->references('id')->on('jobdesk')->onDelete('cascade');
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
