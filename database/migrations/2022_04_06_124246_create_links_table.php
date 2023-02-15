<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $miTiempo = Carbon::now();

        Schema::create('links', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nombre', 2230);
            $table->string('link', 2230);
            $table->string('icon', 50);
            $table->boolean('visible');
            $table->integer('orden');
            $table->unsignedInteger('padre_id')->nullable();

            $table->foreign('padre_id')->references('id')->on('links');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('links')->insert(
            [
                // Configuración
                [ //1
                    'nombre'    => 'Configuración',
                    'link'      => '/configuracion',
                    'icon'      => 'settings-2-outline',
                    'visible'   => true,
                    'orden'     => '5',
                    'padre_id'  => null,
                ],
                [ //2
                    'nombre'    => 'Administración de Usuarios',
                    'link'      => '/usuarios',
                    'icon'      => 'people-outline',
                    'visible'   => true,
                    'orden'     => '1',
                    'padre_id'  => 1,
                ],
                [ //3
                    'nombre'    => 'Administración de Rutas',
                    'link'      => '/links',
                    'icon'      => 'link-2-outline',
                    'visible'   => true,
                    'orden'     => '2',
                    'padre_id'  => 1,
                ],
                [ //4
                    'nombre'    => 'Administración de Permisos',
                    'link'      => '/permisos',
                    'icon'      => 'shield-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 1,
                ],
                // Administrativo
                [ //5
                    'nombre'    => 'Administrativo',
                    'link'      => '/administrativo',
                    'icon'      => 'npm-outline',
                    'visible'   => true,
                    'orden'     => '4',
                    'padre_id'  => null,
                ],
                [ //6
                    'nombre'    => 'Gestión de Sedes',
                    'link'      => '/sedes',
                    'icon'      => 'home-outline',
                    'visible'   => true,
                    'orden'     => '1',
                    'padre_id'  => 5,
                ],
                [ //7
                    'nombre'    => 'Gestión de Facultades',
                    'link'      => '/facultades',
                    'icon'      => 'layout-outline',
                    'visible'   => true,
                    'orden'     => '2',
                    'padre_id'  => 5,
                ],
                [ //8
                    'nombre'    => 'Gestión de Carreras',
                    'link'      => '/carreras',
                    'icon'      => 'book-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 5,
                ],
                [ //9
                    'nombre'    => 'Gestión de Semestres',
                    'link'      => '/semestres',
                    'icon'      => 'award-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 5,
                ],
                [ //10
                    'nombre'    => 'Gestión de Cursos',
                    'link'      => '/cursos',
                    'icon'      => 'copy-outline',
                    'visible'   => true,
                    'orden'     => '4',
                    'padre_id'  => 5,
                ],
                [ //11
                    'nombre'    => 'Gestión de Instituto',
                    'link'      => '/instituto',
                    'icon'      => 'shopping-bag-outline',
                    'visible'   => true,
                    'orden'     => '1',
                    'padre_id'  => 5,
                ],
                //Matricula
                [ //12
                    'nombre'    => 'Matricula',
                    'link'      => '/matricula',
                    'icon'      => 'award-outline',
                    'visible'   => true,
                    'orden'     => '5',
                    'padre_id'  => null,
                ],
                [ //13
                    'nombre'    => 'Selección de Alumnos',
                    'link'      => '/alumnos',
                    'icon'      => 'people-outline',
                    'visible'   => true,
                    'orden'     => '1',
                    'padre_id'  => 12,
                ],
                [ //14
                    'nombre'    => 'Matriculados',
                    'link'      => '/matriculados',
                    'icon'      => 'briefcase-outline',
                    'visible'   => true,
                    'orden'     => '2',
                    'padre_id'  => 12,
                ],
                [ //15
                    'nombre'    => 'Habilitar Cursos',
                    'link'      => '/habilitar-cursos',
                    'icon'      => 'cube-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 12,
                ],
                //Administativo
                [ //16
                    'nombre'    => 'Gestión de Horas',
                    'link'      => '/horas',
                    'icon'      => 'calendar-outline',
                    'visible'   => true,
                    'orden'     => '5',
                    'padre_id'  => 5,
                ],
                //Matricula
                [ //17
                    'nombre'    => 'Habilitar Planes',
                    'link'      => '/habilitar-planes',
                    'icon'      => 'clipboard-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 12,
                ],
                [ //18
                    'nombre'    => 'Matricular',
                    'link'      => '/matricula-alumno',
                    'icon'      => 'file-text-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 12,
                ],
                [//19
                    'nombre'    => 'Culminar Matricula',
                    'link'      => '/culminar-matricula',
                    'icon'      => 'book-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 12,
                ],
                [//20
                    'nombre'    => 'Agregar Alumno(Usuario)',
                    'link'      => '/agregar-alumno',
                    'icon'      => 'person-add-outline',
                    'visible'   => true,
                    'orden'     => '2',
                    'padre_id'  => 12,
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
        Schema::dropIfExists('links');
    }
}
