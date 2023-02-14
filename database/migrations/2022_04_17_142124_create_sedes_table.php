<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre')->unique();
            $table->string('direccion')->nullable();
            $table->string('distrito')->nullable();
            $table->string('provincia')->nullable();
            $table->string('departamento')->nullable();
            $table->string('pais')->nullable();
            $table->string('ubigeo');
            $table->string('codigo')->unique();
            $table->boolean('estado');
            $table->boolean('matricula');


            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('sedes')->insert(
            [
                [//1
                    'nombre'        => 'Antonio Cardenaz Escuela Gastronómica(ACEG) - Juliaca',
                    'direccion'     => 'Jirón sandia N° 843',
                    'distrito'      => 'Juliaca',
                    'provincia'     => 'San Román',
                    'departamento'  => 'Puno',
                    'pais'          => 'Peru',
                    'ubigeo'        => '211101',
                    'codigo'        => 'ACEG-JULIACA',
                    'estado'        => true,
                    'matricula'     => true,
                ]
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
        Schema::dropIfExists('sedes');
    }
}
