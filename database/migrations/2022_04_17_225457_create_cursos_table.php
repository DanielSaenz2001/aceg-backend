<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre', 80)->unique();
            $table->string('tipo', 30);
            $table->boolean('estado');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('cursos')->insert(
            [
                [//1
                    'nombre' => 'Técnicas Gastronómicas I',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//2
                    'nombre' => 'Cocina Peruana Criolla I',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//3
                    'nombre' => 'Innovación Culinaria',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//4
                    'nombre' => 'Técnicas de Bar & Coctelería(Basico)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//5
                    'nombre' => 'Panaderia Básica',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//6
                    'nombre' => 'Reconocimiento de Insumos',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//7
                    'nombre' => 'Bromatología y Dietética',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//8
                    'nombre' => 'Técnicas Gastronómicas II',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//9
                    'nombre' => 'Cocina Peruana Criolla II',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//10
                    'nombre' => 'Catering y Buffet',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//11
                    'nombre' => 'Técnicas de Bar & Coctelería(Avanzado)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//12
                    'nombre' => 'Panaderia Avanzada',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//13
                    'nombre' => 'Técnicas de Servicio y Organización de Eventos',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//14
                    'nombre' => 'Costos, Presupuestos e ingeniería del menú',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//15
                    'nombre' => 'Cocina Peruana Regional(Sur, centro y selva)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//16
                    'nombre' => 'Cocina Chifa',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//17
                    'nombre' => 'Cocina Latinoamericana',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//18
                    'nombre' => 'Complementos y Calidad Gastronómica',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//19
                    'nombre' => 'Pastelería (Básica)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//20
                    'nombre' => 'Marketing gastronómico & Administración de personal',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//21
                    'nombre' => 'Inglés',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//22
                    'nombre' => 'Cocina europea & mediterránea',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//23
                    'nombre' => 'Pescados y Mariscos',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//24
                    'nombre' => 'Pastelería Avanzada e Internacional',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//25
                    'nombre' => 'Cocina saludable y Vegetariana',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//26
                    'nombre' => 'Cocina Exótica',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                ],
                [//27
                    'nombre' => 'Desarrollo de Proyectos',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//29
                    'nombre' => 'Gestión & Equipamiento de Alimientos y Bebidas',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//30
                    'nombre' => 'Panes elaborados a mano',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//31
                    'nombre' => 'Panes Crocantes',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//32
                    'nombre' => 'Panes Suaves',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//33
                    'nombre' => 'Pastas Quebradas',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//34
                    'nombre' => 'Técnicas Pasteleras I',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//35
                    'nombre' => 'Técnicas Pasteleras II',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                ],
                [//36
                    'nombre' => 'Panes Crocantes Comerciales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//37
                    'nombre' => 'Panes Envasados',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//38
                    'nombre' => 'Reposteria Peruana',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//39
                    'nombre' => 'Pasteleria de Vritrina',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//41
                    'nombre' => 'Batidos aireados y semifrios',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//42
                    'nombre' => 'Panes Saborizados',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//43
                    'nombre' => 'Panes Regionales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//44
                    'nombre' => 'Bolleria',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//45
                    'nombre' => 'Tortas Comerciales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//46
                    'nombre' => 'Masa Ojaldres',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//46
                    'nombre' => 'Chocolateria',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//47
                    'nombre' => 'Buffet y Catering',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//48
                    'nombre' => 'Panaderia Fina',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//49
                    'nombre' => 'Panes Crocantes Internacionales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//50
                    'nombre' => 'Panaderia Artesanal y Artistico',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//51
                    'nombre' => 'Panaderia Fina e Internacional',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//52
                    'nombre' => 'Decoraciones de Tortas en Chantilly',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//53
                    'nombre' => 'Decoraciones de Tortas en Masa Elastica',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                ],
                [//54
                    'nombre' => 'Decoraciones con Buttercreamy Frosting',
                    'tipo'   => 'Práctico',
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
        Schema::dropIfExists('cursos');
    }
}
