<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInfoWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_website', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->string('nama_singkatan')->nullable();
            $table->text('tentang');
            $table->string('email');
            $table->text('maps');
            $table->text('logo')->nullable();
            $table->text('logo_mini')->nullable();
            $table->string('footer')->nullable();
            $table->string('telp',20);
            $table->string('alamat');
            $table->string('link_fb')->nullable();
            $table->string('link_tw')->nullable();
            $table->string('link_yt')->nullable();
            $table->string('link_in')->nullable();
            $table->string('link_pi')->nullable();
            $table->string('link_ig')->nullable();
            $table->string('link_gl')->nullable();
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
        Schema::dropIfExists('info_website');
    }
}
