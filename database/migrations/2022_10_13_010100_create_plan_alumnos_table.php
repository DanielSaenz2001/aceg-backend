<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_alumnos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('plan_academico_id');
            $table->unsignedInteger('alumno_id');
            $table->unsignedInteger('semestre_id');
            $table->string('anhio');
            $table->integer('cursos_aprobado');
            $table->integer('cursos_desaprobado');
            $table->integer('creditos_aprobado');
            $table->integer('creditos_desaprobado');
            $table->boolean('estado');

            $table->foreign('alumno_id')->references('id')->on('users');
            $table->foreign('plan_academico_id')->references('id')->on('plan_academico');
            $table->foreign('semestre_id')->references('id')->on('semestres');
            
            $table->unique(['plan_academico_id', 'alumno_id']);

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
        Schema::dropIfExists('plan_alumnos');
    }
}
