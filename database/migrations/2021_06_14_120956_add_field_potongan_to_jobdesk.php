<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPotonganToJobdesk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobdesk', function (Blueprint $table) {
            $table->bigInteger('potongan_pengeluaran')->nullable();
            $table->bigInteger('potongan_utama')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobdesk', function (Blueprint $table) {
            //
        });
    }
}
