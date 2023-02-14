<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestresCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres_cursos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('plan_curso_id');
            $table->unsignedInteger('semestre_id');
            $table->unsignedInteger('docente_id')->nullable();

            $table->integer('cupos');
            $table->integer('grupo');


            $table->foreign('plan_curso_id')->references('id')->on('plan_cursos');
            $table->foreign('semestre_id')->references('id')->on('semestres');
            $table->foreign('docente_id')->references('id')->on('users');
            
            $table->unique(['plan_curso_id', 'semestre_id', 'grupo']);

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
        Schema::dropIfExists('semestres_cursos');
    }
}
