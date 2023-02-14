<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestresPlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres_planes', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('plan_academico_id');
            $table->unsignedInteger('semestre_id');

            $table->foreign('plan_academico_id')->references('id')->on('plan_academico');
            $table->foreign('semestre_id')->references('id')->on('semestres');
            
            $table->unique(['plan_academico_id', 'semestre_id']);
            
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
        Schema::dropIfExists('semestres_planes');
    }
}
