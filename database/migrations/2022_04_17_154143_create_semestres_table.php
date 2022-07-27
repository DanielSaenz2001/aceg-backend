<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateSemestresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $miTiempo = Carbon::now();

        Schema::create('semestres', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre', 9)->unique();
            $table->boolean('estado');
            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('semestres')->insert(
            [
                [
                    'nombre' => '2022-1',
                    'estado' => true,
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
                ],
                [
                    'nombre' => '2022-2',
                    'estado' => true,
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
                ],
                [
                    'nombre' => '2022-3',
                    'estado' => true,
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
        Schema::dropIfExists('semestres');
    }
}
