<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualityObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('kode_frm');
            $table->string('tahun');
            $table->string('bulan');
            $table->integer('jumlah_layanan');
            $table->integer('range_1');
            $table->integer('range_2');
            $table->integer('range_3');
            $table->float('persentase_tercapai', 100,2);
            $table->float('persentase_tdk_tercapai', 100,2);
            $table->string('alasan');
            $table->string('catatan_tinjut');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_objectives');
    }
}
