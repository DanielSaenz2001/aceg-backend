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
                [//1
                    'nombre' => 'Administración de Usuarios',
                    'codigo' => 'GUsuarios',
                    'activo' => true
                ],
                [//2
                    'nombre' => 'Administración de Rutas',
                    'codigo' => 'GRutas',
                    'activo' => true
                ],
                [//3
                    'nombre' => 'Administración de Permisos',
                    'codigo' => 'GPermisos',
                    'activo' => true
                ],
                [//4
                    'nombre' => 'Administración de Sedes',
                    'codigo' => 'GSedes',
                    'activo' => true
                ],
                [//5
                    'nombre' => 'Administración de Facultades',
                    'codigo' => 'GFacultades',
                    'activo' => true
                ],
                [//6
                    'nombre' => 'Administración de Carreras',
                    'codigo' => 'GCarreras',
                    'activo' => true
                ],
                [//7
                    'nombre' => 'Administración de Semestres',
                    'codigo' => 'GSemestres',
                    'activo' => true
                ],
                [//8
                    'nombre' => 'Administración de Cursos',
                    'codigo' => 'GCursos',
                    'activo' => true
                ],
                [//9
                    'nombre' => 'Gestión de Instituto',
                    'codigo' => 'GInstituto',
                    'activo' => true
                ],
                [//10
                    'nombre' => 'Matricula Alumnos',
                    'codigo' => 'MAlumnos',
                    'activo' => true
                ],
                [//11
                    'nombre' => 'Matriculados',
                    'codigo' => 'MMatriculados',
                    'activo' => true
                ],
                [//12
                    'nombre' => 'Alumnos',
                    'codigo' => 'Alumno',
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
