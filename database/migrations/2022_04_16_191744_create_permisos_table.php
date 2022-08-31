<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->boolean('activo');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('permisos')->insert(
            [
                [
                    'nombre' => 'Administración de Usuarios',
                    'codigo' => 'GUsuarios',
                    'activo' => true
                ],
                [
                    'nombre' => 'Administración de Rutas',
                    'codigo' => 'GRutas',
                    'activo' => true
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
        Schema::dropIfExists('permisos');
    }
}
