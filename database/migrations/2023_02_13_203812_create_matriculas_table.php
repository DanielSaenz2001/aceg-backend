<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('semestre_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('alumno_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->tinyInteger('estado');

            $table->foreign('semestre_id')->references('id')->on('semestres');
            $table->foreign('plan_id')->references('id')->on('plan_academico');
            $table->foreign('alumno_id')->references('id')->on('users');
            $table->unique(['semestre_id', 'plan_id', 'alumno_id']);
            
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
        Schema::dropIfExists('matriculas');
    }
}
