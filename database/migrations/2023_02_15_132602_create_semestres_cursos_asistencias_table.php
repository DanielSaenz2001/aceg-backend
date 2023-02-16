<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestresCursosAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres_cursos_asistencias', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('sem_cur_id');
            $table->unsignedInteger('alum_id');
            $table->date('fecha');
            $table->tinyInteger('estado');
            $table->string('justificacion')->nullable();

            $table->foreign('sem_cur_id')->references('id')->on('semestres_cursos');
            $table->foreign('alum_id')->references('id')->on('users');
            
            $table->unique(['sem_cur_id', 'alum_id', 'fecha']);
            
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
        Schema::dropIfExists('semestres_cursos_asistencias');
    }
}
