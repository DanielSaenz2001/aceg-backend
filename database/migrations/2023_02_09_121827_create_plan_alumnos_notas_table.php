<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanAlumnosNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_alumnos_notas', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('plan_alumno_id');
            $table->unsignedInteger('plan_curso_id');
            $table->float('nota', 8 ,2)->nullable();
            $table->tinyInteger('estado');

            $table->foreign('plan_alumno_id')->references('id')->on('plan_alumnos');
            $table->foreign('plan_curso_id')->references('id')->on('plan_cursos');
            
            $table->unique(['plan_alumno_id', 'plan_curso_id']);

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
        Schema::dropIfExists('plan_alumnos_notas');
    }
}
