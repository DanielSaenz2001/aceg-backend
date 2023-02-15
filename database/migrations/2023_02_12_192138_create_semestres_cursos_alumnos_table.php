<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestresCursosAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres_cursos_alumnos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('semestres_curso_id');
            $table->unsignedInteger('alumno_id');
            $table->unsignedInteger('matricula_id');
            $table->boolean('estado');

            $table->foreign('semestres_curso_id')->references('id')->on('semestres_cursos');
            $table->foreign('alumno_id')->references('id')->on('users');
            $table->foreign('matricula_id')->references('id')->on('matriculas');
            
            $table->unique(['semestres_curso_id', 'alumno_id', 'matricula_id']);
            
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
        Schema::dropIfExists('semestres_cursos_alumnos');
    }
}
