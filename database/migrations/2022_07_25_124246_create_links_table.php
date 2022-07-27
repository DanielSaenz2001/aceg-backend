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
            $table->integer('orden');
            $table->unsignedInteger('padre_id')->nullable();

            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('padre_id')->references('id')->on('links');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('links')->insert(
            [
                
                [
                    'nombre'    => 'Portal Admin',
                    'link'      => '/admin',
                    'orden'     => '1',
                    'padre_id'  => null,
                    'usuario'   => 'aceg.admin',
                    'creado'    => $miTiempo,
                    'modificado'=> $miTiempo
                ],
                [
                    'nombre'      => 'Administración de Rutas',
                    'link'      => '/links',
                    'orden'     => '1',
                    'padre_id'  => 1,
                    'usuario'   => 'aceg.admin',
                    'creado'    => $miTiempo,
                    'modificado'=> $miTiempo
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
