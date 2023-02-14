<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateSemestresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre', 9)->unique();
            $table->date('inicio');
            $table->date('fin');
            $table->boolean('estado');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
        
        $miTiempo = Carbon::now();

        DB::table('semestres')->insert(
            [
                [
                    'nombre' => '2023-1',
                    'estado' => true,
                    'inicio' => '2023-03-06',
                    'fin'    => '2023-07-21'
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
