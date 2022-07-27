<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCursosUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_cursos_unidad', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->integer('unidad');
            $table->string('descripcion', 2230);
            $table->string('resultados', 2230);
            $table->unsignedInteger('plan_curso_id');

            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('plan_curso_id')->references('id')->on('plan_cursos');
            
            $table->unique('unidad', 'plan_curso_id');

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
        Schema::dropIfExists('plan_cursos_unidad');
    }
}
