<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facultades', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre')->unique();
            $table->string('codigo')->unique();
            $table->boolean('estado');
            $table->unsignedInteger('sede_id');
            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('sede_id')->references('id')->on('sedes');

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
        Schema::dropIfExists('facultades');
    }
}
