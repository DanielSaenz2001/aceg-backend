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
            $table->unsignedInteger('plan_periodo_id');
            $table->unsignedInteger('curso_id');
            $table->integer('creditos');
            $table->integer('hora_teorica');
            $table->integer('hora_practica');
            $table->integer('nota_minima');


            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->foreign('plan_periodo_id')->references('id')->on('plan_periodos');
            
            $table->unique(['curso_id', 'plan_periodo_id']);

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
        
        DB::table('plan_cursos')->insert(
            [
                [//1
                    'plan_periodo_id'   => 1,
                    'curso_id'          => 1,
                    'creditos'          => 3,
                    'hora_teorica'      => 2,
                    'hora_practica'     => 0,
                    'nota_minima'       => 13,
                ],
            ]
        );
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
