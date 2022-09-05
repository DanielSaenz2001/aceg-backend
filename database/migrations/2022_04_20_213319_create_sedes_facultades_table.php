<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesFacultadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes_facultades', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('sede_id');
            $table->unsignedInteger('facultad_id');

            $table->foreign('facultad_id')->references('id')->on('facultades');
            $table->foreign('sede_id')->references('id')->on('sedes');

            $table->unique(['sede_id', 'facultad_id']);
            
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('sedes_facultades')->insert(
            [
                [//1
                    'facultad_id'   => 1,
                    'sede_id'       => 1,
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
        Schema::dropIfExists('sedes_facultades');
    }
}
