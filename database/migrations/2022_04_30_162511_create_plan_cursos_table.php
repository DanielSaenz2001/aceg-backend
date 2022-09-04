<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_cursos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre');
            $table->integer('creditos');
            $table->integer('hora_teorica');
            $table->integer('hora_practica');
            $table->integer('nota_minima');
            $table->string('sumilla', 1230);
            $table->string('competencia', 1230);
            $table->unsignedInteger('plan_ciclo_id');
            $table->boolean('estado');

            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('plan_ciclo_id')->references('id')->on('plan_ciclos');
            
            $table->unique('nombre', 'plan_ciclo_id');

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
        Schema::dropIfExists('plan_cursos');
    }
}
