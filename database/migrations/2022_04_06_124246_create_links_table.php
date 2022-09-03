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

                [
                    'nombre'    => 'Configuración',
                    'link'      => '/configuracion',
                    'icon'      => 'settings-2-outline',
                    'visible'   => true,
                    'orden'     => '1',
                    'padre_id'  => null,
                ],
                [
                    'nombre'      => 'Administración de Usuarios',
                    'link'      => '/usuarios',
                    'icon'      => 'people-outline',
                    'visible'   => true,
                    'orden'     => '1',
                    'padre_id'  => 1,
                ],
                [
                    'nombre'      => 'Administración de Rutas',
                    'link'      => '/links',
                    'icon'      => 'link-2-outline',
                    'visible'   => true,
                    'orden'     => '2',
                    'padre_id'  => 1,
                ],
                [
                    'nombre'      => 'Administración de Permisos',
                    'link'      => '/permisos',
                    'icon'      => 'shield-outline',
                    'visible'   => true,
                    'orden'     => '3',
                    'padre_id'  => 1,
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
