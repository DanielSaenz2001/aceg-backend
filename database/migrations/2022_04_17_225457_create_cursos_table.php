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
            $table->longText('sumilla');
            $table->longText('competencia');
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
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//2
                    'nombre' => 'Cocina Peruana Criolla I',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//3
                    'nombre' => 'Innovación Culinaria',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//4
                    'nombre' => 'Técnicas de Bar & Coctelería(Basico)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//5
                    'nombre' => 'Panaderia Básica',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//6
                    'nombre' => 'Reconocimiento de Insumos',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//7
                    'nombre' => 'Bromatología y Dietética',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//8
                    'nombre' => 'Técnicas Gastronómicas II',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//9
                    'nombre' => 'Cocina Peruana Criolla II',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//10
                    'nombre' => 'Catering y Buffet',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//11
                    'nombre' => 'Técnicas de Bar & Coctelería(Avanzado)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//12
                    'nombre' => 'Panaderia Avanzada',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//13
                    'nombre' => 'Técnicas de Servicio y Organización de Eventos',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//14
                    'nombre' => 'Costos, Presupuestos e ingeniería del menú',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//15
                    'nombre' => 'Cocina Peruana Regional(Sur, centro y selva)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//16
                    'nombre' => 'Cocina Chifa',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//17
                    'nombre' => 'Cocina Latinoamericana',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//18
                    'nombre' => 'Complementos y Calidad Gastronómica',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//19
                    'nombre' => 'Pastelería (Básica)',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//20
                    'nombre' => 'Marketing gastronómico & Administración de personal',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//21
                    'nombre' => 'Inglés',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//22
                    'nombre' => 'Cocina europea & mediterránea',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//23
                    'nombre' => 'Pescados y Mariscos',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//24
                    'nombre' => 'Pastelería Avanzada e Internacional',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//25
                    'nombre' => 'Cocina saludable y Vegetariana',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//26
                    'nombre' => 'Cocina Exótica',
                    'tipo'   => 'Prácticos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//27
                    'nombre' => 'Desarrollo de Proyectos',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//29
                    'nombre' => 'Gestión & Equipamiento de Alimientos y Bebidas',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//30
                    'nombre' => 'Panes elaborados a mano',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//31
                    'nombre' => 'Panes Crocantes',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//32
                    'nombre' => 'Panes Suaves',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//33
                    'nombre' => 'Pastas Quebradas',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//34
                    'nombre' => 'Técnicas Pasteleras I',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//35
                    'nombre' => 'Técnicas Pasteleras II',
                    'tipo'   => 'Teóricos',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//36
                    'nombre' => 'Panes Crocantes Comerciales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//37
                    'nombre' => 'Panes Envasados',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//38
                    'nombre' => 'Reposteria Peruana',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//39
                    'nombre' => 'Pasteleria de Vritrina',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//41
                    'nombre' => 'Batidos aireados y semifrios',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//42
                    'nombre' => 'Panes Saborizados',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//43
                    'nombre' => 'Panes Regionales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//44
                    'nombre' => 'Bolleria',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//45
                    'nombre' => 'Tortas Comerciales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//46
                    'nombre' => 'Masa Ojaldres',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//46
                    'nombre' => 'Chocolateria',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//47
                    'nombre' => 'Buffet y Catering',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//48
                    'nombre' => 'Panaderia Fina',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//49
                    'nombre' => 'Panes Crocantes Internacionales',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//50
                    'nombre' => 'Panaderia Artesanal y Artistico',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//51
                    'nombre' => 'Panaderia Fina e Internacional',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//52
                    'nombre' => 'Decoraciones de Tortas en Chantilly',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//53
                    'nombre' => 'Decoraciones de Tortas en Masa Elastica',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
                ],
                [//54
                    'nombre' => 'Decoraciones con Buttercreamy Frosting',
                    'tipo'   => 'Práctico',
                    'estado' => true,
                    'sumilla'=> '',
                    'competencia' => ''
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
