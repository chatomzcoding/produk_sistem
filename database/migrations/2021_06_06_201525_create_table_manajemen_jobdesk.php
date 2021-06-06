<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableManajemenJobdesk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manajemen_jobdesk', function (Blueprint $table) {
            $table->id();
            $table->string('tingkatan',100);
            $table->text('catatan');
            $table->string('skala_prioritas');
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
        Schema::dropIfExists('manajemen_jobdesk');
    }
}
