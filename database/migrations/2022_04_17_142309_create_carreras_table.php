<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre')->unique();
            $table->string('codigo')->unique();
            $table->boolean('estado');
            $table->unsignedInteger('facultad_id');
            $table->foreign('facultad_id')->references('id')->on('facultades');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('carreras')->insert(
            [
                [//1
                    'nombre'        => 'Cocina',
                    'codigo'        => 'Cook',
                    'estado'        => true,
                    'facultad_id'   => 1,
                ],
                [//2
                    'nombre'        => 'Panaderia y Pasteleria',
                    'codigo'        => 'Panederia',
                    'estado'        => true,
                    'facultad_id'   => 1,
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
        Schema::dropIfExists('carreras');
    }
}
