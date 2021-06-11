<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToMonitoringJobdesk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitoring_jobdesk', function (Blueprint $table) {
            $table->unsignedBigInteger('manajemenjobdesk_id')->after('id');
            $table->foreign('manajemenjobdesk_id')->references('id')->on('manajemen_jobdesk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitoring_jobdesk', function (Blueprint $table) {
            //
        });
    }
}
