<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talleres', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre', 30)->unique();
            $table->string('tipo', 30);
            $table->boolean('estado');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('cursos')->insert(
            [
                [//1
                    'nombre' => 'Ofimática(Word y Excel)',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//2
                    'nombre' => 'Liderazgo y Trabajo en Equipo',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//3
                    'nombre' => 'Tecnología de Alimentos',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//4
                    'nombre' => 'Cocina Rápida(Fast Food)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//5
                    'nombre' => 'BPM-HACCP',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//6
                    'nombre' => 'Valor energéticode los alimentos',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//7
                    'nombre' => 'Funciones fisicoquímicas de los insumos',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//8
                    'nombre' => 'Herramientas y equipos de trabajo',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//8
                    'nombre' => 'Costeo',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//8
                    'nombre' => 'Porcentaje panadero y pastelero',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
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
        Schema::dropIfExists('tallers');
    }
}
