<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatisfactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satisfactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nama');
            $table->string('nim');
            $table->string('departemen');
            $table->string('jenis_kelamin');
            $table->string('jalur_masuk');
            $table->string('periode_wisuda');
            $table->string('tahun_masuk');
            $table->float('ipk');

            $table->smallInteger('kuliah');
            $table->smallInteger('praktikum');
            $table->smallInteger('penelitian');
            $table->smallInteger('pembimbingan');

            $table->smallInteger('dep_adm');
            $table->smallInteger('dep_keb');
            $table->smallInteger('dep_t');
            $table->smallInteger('dep_hot');

            $table->smallInteger('dek_adm');
            $table->smallInteger('dek_keb');
            $table->smallInteger('dek_t');
            $table->smallInteger('dek_hot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satisfactions');
    }
}
