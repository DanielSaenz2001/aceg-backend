<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateLinksRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $miTiempo = Carbon::now();
        Schema::create('links_roles', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('link_id');

            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('link_id')->references('id')->on('links');

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('links_roles')->insert(
            [
                [
                    'role_id'   => 1,
                    'link_id'   => 2,
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
        Schema::dropIfExists('links_roles');
    }
}
