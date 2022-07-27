<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $miTiempo = Carbon::now();

        Schema::create('roles', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('roles')->insert(
            [
                [
                    'nombre' => 'Administrador',
                    'codigo' => 'Admin',
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
                ],
                [
                    'nombre' => 'Matriculador',
                    'codigo' => 'Matri',
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
                ],
                [
                    'nombre' => 'Alumno',
                    'codigo' => 'Alum',
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
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
        Schema::dropIfExists('roles');
    }
}
