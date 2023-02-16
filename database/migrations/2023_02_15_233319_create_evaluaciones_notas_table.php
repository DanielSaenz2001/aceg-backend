<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones_notas', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('evaluacion_id');
            $table->unsignedInteger('alumno_id');
            $table->float('nota', 8 ,2);

            $table->foreign('evaluacion_id')->references('id')->on('semestres_cursos_evaluaciones');
            $table->foreign('alumno_id')->references('id')->on('users');
            
            $table->unique(['evaluacion_id', 'alumno_id',]);
            
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones_notas');
    }
}
