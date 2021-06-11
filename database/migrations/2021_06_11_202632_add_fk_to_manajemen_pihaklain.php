<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToManajemenPihaklain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manajemen_pihaklain', function (Blueprint $table) {
            $table->unsignedBigInteger('proyek_id')->after('id');
            $table->foreign('proyek_id')->references('id')->on('proyek')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->after('proyek_id');
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
        Schema::table('manajemen_pihaklain', function (Blueprint $table) {
            //
        });
    }
}
