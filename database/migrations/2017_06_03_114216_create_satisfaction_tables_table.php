<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatisfactionTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satisfaction_tables', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();

          $table->string('periode_wisuda')->nullable();
          $table->string('tanggal_wisuda')->nullable();
          $table->string('tahun_akademik')->nullable();

          $table->decimal('mipa_na1', 4,2)->nullable();
          $table->decimal('mipa_na2', 4,2)->nullable();
          $table->decimal('mipa_na3', 4,2)->nullable();
          $table->decimal('mipa_na4', 4,2)->nullable();

          $table->decimal('stk_a1', 4,2)->nullable();
          $table->decimal('stk_a2', 4,2)->nullable();
          $table->decimal('stk_a3', 4,2)->nullable();
          $table->decimal('stk_a4', 4,2)->nullable();
          $table->decimal('stk_na1', 4,2)->nullable();
          $table->decimal('stk_na2', 4,2)->nullable();
          $table->decimal('stk_na3', 4,2)->nullable();
          $table->decimal('stk_na4', 4,2)->nullable();

          $table->decimal('gfm_a1', 4,2)->nullable();
          $table->decimal('gfm_a2', 4,2)->nullable();
          $table->decimal('gfm_a3', 4,2)->nullable();
          $table->decimal('gfm_a4', 4,2)->nullable();
          $table->decimal('gfm_na1', 4,2)->nullable();
          $table->decimal('gfm_na2', 4,2)->nullable();
          $table->decimal('gfm_na3', 4,2)->nullable();
          $table->decimal('gfm_na4', 4,2)->nullable();

          $table->decimal('bio_a1', 4,2)->nullable();
          $table->decimal('bio_a2', 4,2)->nullable();
          $table->decimal('bio_a3', 4,2)->nullable();
          $table->decimal('bio_a4', 4,2)->nullable();
          $table->decimal('bio_na1', 4,2)->nullable();
          $table->decimal('bio_na2', 4,2)->nullable();
          $table->decimal('bio_na3', 4,2)->nullable();
          $table->decimal('bio_na4', 4,2)->nullable();

          $table->decimal('kim_a1', 4,2)->nullable();
          $table->decimal('kim_a2', 4,2)->nullable();
          $table->decimal('kim_a3', 4,2)->nullable();
          $table->decimal('kim_a4', 4,2)->nullable();
          $table->decimal('kim_na1', 4,2)->nullable();
          $table->decimal('kim_na2', 4,2)->nullable();
          $table->decimal('kim_na3', 4,2)->nullable();
          $table->decimal('kim_na4', 4,2)->nullable();

          $table->decimal('mat_a1', 4,2)->nullable();
          $table->decimal('mat_a2', 4,2)->nullable();
          $table->decimal('mat_a3', 4,2)->nullable();
          $table->decimal('mat_a4', 4,2)->nullable();
          $table->decimal('mat_na1', 4,2)->nullable();
          $table->decimal('mat_na2', 4,2)->nullable();
          $table->decimal('mat_na3', 4,2)->nullable();
          $table->decimal('mat_na4', 4,2)->nullable();

          $table->decimal('kom_a1', 4,2)->nullable();
          $table->decimal('kom_a2', 4,2)->nullable();
          $table->decimal('kom_a3', 4,2)->nullable();
          $table->decimal('kom_a4', 4,2)->nullable();
          $table->decimal('kom_na1', 4,2)->nullable();
          $table->decimal('kom_na2', 4,2)->nullable();
          $table->decimal('kom_na3', 4,2)->nullable();
          $table->decimal('kom_na4', 4,2)->nullable();

          $table->decimal('fis_a1', 4,2)->nullable();
          $table->decimal('fis_a2', 4,2)->nullable();
          $table->decimal('fis_a3', 4,2)->nullable();
          $table->decimal('fis_a4', 4,2)->nullable();
          $table->decimal('fis_na1', 4,2)->nullable();
          $table->decimal('fis_na2', 4,2)->nullable();
          $table->decimal('fis_na3', 4,2)->nullable();
          $table->decimal('fis_na4', 4,2)->nullable();

          $table->decimal('bik_a1', 4,2)->nullable();
          $table->decimal('bik_a2', 4,2)->nullable();
          $table->decimal('bik_a3', 4,2)->nullable();
          $table->decimal('bik_a4', 4,2)->nullable();
          $table->decimal('bik_na1', 4,2)->nullable();
          $table->decimal('bik_na2', 4,2)->nullable();
          $table->decimal('bik_na3', 4,2)->nullable();
          $table->decimal('bik_na4', 4,2)->nullable();

          $table->decimal('mipa_rata', 4,2)->nullable();
          $table->decimal('stk_rata', 4,2)->nullable();
          $table->decimal('gfm_rata', 4,2)->nullable();
          $table->decimal('bio_rata', 4,2)->nullable();
          $table->decimal('kim_rata', 4,2)->nullable();
          $table->decimal('mat_rata', 4,2)->nullable();
          $table->decimal('kom_rata', 4,2)->nullable();
          $table->decimal('fis_rata', 4,2)->nullable();
          $table->decimal('bik_rata', 4,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satisfaction_tables');
    }
}
