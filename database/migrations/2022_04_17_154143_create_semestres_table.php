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

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('semestres')->insert(
            [
                [
                    'nombre' => '2022-1',
                    'estado' => true,
                ],
                [
                    'nombre' => '2022-2',
                    'estado' => true,
                ],
                [
                    'nombre' => '2022-M',
                    'estado' => true,
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
