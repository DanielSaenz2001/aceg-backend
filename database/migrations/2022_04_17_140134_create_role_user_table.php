<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $miTiempo = Carbon::now();

        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('rol_id');
            $table->string('usuario')->nullable();
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('rol_id')->references('id')->on('roles');

            $table->unique('user_id', 'rol_id');
            
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('role_user')->insert(
            [
                [
                    'user_id' => '1',
                    'rol_id' => '1',
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
                ],
                [
                    'user_id' => '2',
                    'rol_id' => '2',
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
                ],
                [
                    'user_id' => '3',
                    'rol_id' => '3',
                    'usuario' => 'aceg.admin',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo
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
        Schema::dropIfExists('role_user');
    }
}
