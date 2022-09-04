<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCiclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_ciclos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('ciclo');
            $table->unsignedInteger('plan_academico_id');

            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('plan_academico_id')->references('id')->on('plan_academico');
            
            $table->unique('ciclo', 'plan_academico_id');

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
        Schema::dropIfExists('plan_ciclos');
    }
}
