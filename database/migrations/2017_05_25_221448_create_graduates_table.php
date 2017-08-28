<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nama');
            $table->string('nim', 9);
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('program_studi');
            $table->string('tanggal_lulus');
            $table->string('judul_laporan');
            $table->string('dosbing1');
            $table->string('dosbing2');
            $table->float('ipk');
            $table->string('predikat');
            $table->string('periode_wisuda');
            $table->string('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graduates');
    }
}
