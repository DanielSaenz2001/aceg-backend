<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanAcademicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_academico', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('facultad_carrera_id');
            $table->unsignedInteger('semestre_id');
            $table->boolean('estado');

            $table->foreign('semestre_id')->references('id')->on('semestres');
            $table->foreign('facultad_carrera_id')->references('id')->on('facultades_carreras');
            
            $table->unique(['facultad_carrera_id', 'semestre_id']);

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
        
        DB::table('plan_academico')->insert(
            [
                [//1
                    'facultad_carrera_id'   => 1,
                    'semestre_id'           => 1,
                    'estado'                => true,
                ],
                [//2
                    'facultad_carrera_id'   => 2,
                    'semestre_id'           => 1,
                    'estado'                => true,
                ],
            ]
        );
    }


    
    public function down()
    {
        Schema::dropIfExists('plan_academico');
    }
}
