<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dias', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->date('nombre');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('dias')->insert(
            [
                [//1
                    'nombre' => 'Domingo',
                ],
                [//2
                    'nombre' => 'Lunes',
                ],
                [//3
                    'nombre' => 'Martes',
                ],
                [//4
                    'nombre' => 'Miercoles',
                ],
                [//5
                    'nombre' => 'Jueves',
                ],
                [//6
                    'nombre' => 'Viernes',
                ],
                [//7
                    'nombre' => 'Sabado',
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
        Schema::dropIfExists('dias');
    }
}
