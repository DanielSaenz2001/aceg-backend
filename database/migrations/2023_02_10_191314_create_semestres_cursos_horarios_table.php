<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestresCursosHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres_cursos_horarios', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('semestres_curso_id');
            $table->unsignedInteger('hora_id');
            $table->unsignedInteger('dia_id');

            $table->foreign('semestres_curso_id')->references('id')->on('semestres_cursos');
            $table->foreign('hora_id')->references('id')->on('horas');
            $table->foreign('dia_id')->references('id')->on('dias');
            
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
        Schema::dropIfExists('semestres_cursos_horarios');
    }
}
