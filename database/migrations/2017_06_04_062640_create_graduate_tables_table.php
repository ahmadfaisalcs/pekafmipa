<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduate_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('periode_wisuda')->nullable();
            $table->string('tanggal_wisuda')->nullable();
            $table->string('tahun_akademik')->nullable();

            $table->decimal('g0_ipk_rata', 4,2)->nullable();
            $table->decimal('g0_ipk_max', 4,2)->nullable();
            $table->decimal('g0_ipk_min', 4,2)->nullable();
            $table->integer('g0_studi_rata')->nullable();
            $table->integer('g0_studi_max')->nullable();
            $table->integer('g0_studi_min')->nullable();

            $table->decimal('g1_ipk_rata', 4,2)->nullable();
            $table->decimal('g1_ipk_max', 4,2)->nullable();
            $table->decimal('g1_ipk_min', 4,2)->nullable();
            $table->integer('g1_studi_rata')->nullable();
            $table->integer('g1_studi_max')->nullable();
            $table->integer('g1_studi_min')->nullable();

            $table->decimal('g2_ipk_rata', 4,2)->nullable();
            $table->decimal('g2_ipk_max', 4,2)->nullable();
            $table->decimal('g2_ipk_min', 4,2)->nullable();
            $table->integer('g2_studi_rata')->nullable();
            $table->integer('g2_studi_max')->nullable();
            $table->integer('g2_studi_min')->nullable();

            $table->decimal('g3_ipk_rata', 4,2)->nullable();
            $table->decimal('g3_ipk_max', 4,2)->nullable();
            $table->decimal('g3_ipk_min', 4,2)->nullable();
            $table->integer('g3_studi_rata')->nullable();
            $table->integer('g3_studi_max')->nullable();
            $table->integer('g3_studi_min')->nullable();

            $table->decimal('g4_ipk_rata', 4,2)->nullable();
            $table->decimal('g4_ipk_max', 4,2)->nullable();
            $table->decimal('g4_ipk_min', 4,2)->nullable();
            $table->integer('g4_studi_rata')->nullable();
            $table->integer('g4_studi_max')->nullable();
            $table->integer('g4_studi_min')->nullable();

            $table->decimal('g5_ipk_rata', 4,2)->nullable();
            $table->decimal('g5_ipk_max', 4,2)->nullable();
            $table->decimal('g5_ipk_min', 4,2)->nullable();
            $table->integer('g5_studi_rata')->nullable();
            $table->integer('g5_studi_max')->nullable();
            $table->integer('g5_studi_min')->nullable();

            $table->decimal('g6_ipk_rata', 4,2)->nullable();
            $table->decimal('g6_ipk_max', 4,2)->nullable();
            $table->decimal('g6_ipk_min', 4,2)->nullable();
            $table->integer('g6_studi_rata')->nullable();
            $table->integer('g6_studi_max')->nullable();
            $table->integer('g6_studi_min')->nullable();

            $table->decimal('g7_ipk_rata', 4,2)->nullable();
            $table->decimal('g7_ipk_max', 4,2)->nullable();
            $table->decimal('g7_ipk_min', 4,2)->nullable();
            $table->integer('g7_studi_rata')->nullable();
            $table->integer('g7_studi_max')->nullable();
            $table->integer('g7_studi_min')->nullable();

            $table->decimal('g8_ipk_rata', 4,2)->nullable();
            $table->decimal('g8_ipk_max', 4,2)->nullable();
            $table->decimal('g8_ipk_min', 4,2)->nullable();
            $table->integer('g8_studi_rata')->nullable();
            $table->integer('g8_studi_max')->nullable();
            $table->integer('g8_studi_min')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graduate_tables');
    }
}
