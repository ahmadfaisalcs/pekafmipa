<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('requests', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->string('jenis_frm');
          $table->string('id_mahasiswa');
          $table->string('nama');
          $table->string('nim', 9);
          $table->string('prodi');
          $table->string('semester')->nullable();
          $table->string('keperluan');
          $table->string('telp');
          $table->string('email');
          $table->string('keterangan');
          $table->string('finished_at');
          $table->string('spp')->nullable();
          $table->string('ktm')->nullable();
          $table->string('srt_pengantar')->nullable();
          $table->string('srt_cuti')->nullable();
          $table->string('srt_undurdiri')->nullable();
          $table->string('srt_sidkom')->nullable();
          $table->string('srt_rencanastudi')->nullable();
          $table->string('foto')->nullable();
          $table->string('srt_keterangan')->nullable();
          $table->string('transkrip')->nullable();
          $table->string('lbr_pengesahan')->nullable();
          $table->string('byr_wisuda')->nullable();
          $table->string('skl')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
