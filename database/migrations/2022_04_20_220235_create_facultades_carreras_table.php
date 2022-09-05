<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadesCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facultades_carreras', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('sede_facultad_id');
            $table->unsignedInteger('carrera_id');

            $table->foreign('sede_facultad_id')->references('id')->on('sedes_facultades');
            $table->foreign('carrera_id')->references('id')->on('carreras');

            $table->unique(['sede_facultad_id', 'carrera_id']);
            
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('facultades_carreras')->insert(
            [
                [//1
                    'sede_facultad_id'   => 1,
                    'carrera_id'         => 1,
                ],
                [//2
                    'sede_facultad_id'   => 1,
                    'carrera_id'         => 2,
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facultades_carreras');
    }
}
