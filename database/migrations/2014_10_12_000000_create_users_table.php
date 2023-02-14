<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $miTiempo = Carbon::now();

        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('dni', 9)->unique();
            $table->string('nombres', 255);
            $table->string('apellido_paterno', 255);
            $table->string('apellido_materno', 255);
            $table->string('direccion', 510)->nullable();
            $table->string('sexo', 1);
            $table->string('email', 100)->unique();
            $table->date('fecha_nacimiento');
            $table->string('imagen',500)->nullable();
            $table->string('celular', 100)->unique();
            $table->boolean('estado');
            $table->string('usuario', 20)->unique();
            $table->string('password');
            $table->timestamp('creado')->nullable();
            $table->timestamp('modificado')->nullable();

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('users')->insert(
            [
                [
                    'dni' => '00000001',
                    'nombres' => 'ACEG',
                    'apellido_paterno' => 'Super',
                    'apellido_materno' => 'Admin',
                    'direccion' => 'ACEG',
                    'sexo' => 'N',
                    'email' => 'aceg.admin@aceg.edu.pe',
                    'fecha_nacimiento' => $miTiempo,
                    'celular' => '000000001',
                    'usuario' => 'aceg.admin',
                    'estado' => true,
                    'password' => '$2y$10$JV4U.EfcQgNPGPPmRjmnu.D7q0wWRoFlK.4DIFpxfnnubza.hF7Hm',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo,
                ],
                [
                    'dni' => '00000002',
                    'nombres' => 'ACEG',
                    'apellido_paterno' => 'Super',
                    'apellido_materno' => 'Matri',
                    'direccion' => 'ACEG',
                    'sexo' => 'N',
                    'email' => 'aceg.matri@aceg.edu.pe',
                    'fecha_nacimiento' => $miTiempo,
                    'celular' => '000000002',
                    'usuario' => 'aceg.matri',
                    'estado' => true,
                    'password' => '$2y$10$JV4U.EfcQgNPGPPmRjmnu.D7q0wWRoFlK.4DIFpxfnnubza.hF7Hm',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo,
                ],
                [
                    'dni' => '00000003',
                    'nombres' => 'ACEG',
                    'apellido_paterno' => 'Super',
                    'apellido_materno' => 'Alum',
                    'direccion' => 'ACEG',
                    'sexo' => 'N',
                    'email' => 'aceg.alum@aceg.edu.pe',
                    'fecha_nacimiento' => $miTiempo,
                    'celular' => '000000003',
                    'usuario' => 'aceg.alum',
                    'estado' => true,
                    'password' => '$2y$10$JV4U.EfcQgNPGPPmRjmnu.D7q0wWRoFlK.4DIFpxfnnubza.hF7Hm',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo,
                ],
                [
                    'dni' => '00000004',
                    'nombres' => 'ACEG',
                    'apellido_paterno' => 'Super',
                    'apellido_materno' => 'Docent',
                    'direccion' => 'ACEG',
                    'sexo' => 'N',
                    'email' => 'aceg.docent@aceg.edu.pe',
                    'fecha_nacimiento' => $miTiempo,
                    'celular' => '000000004',
                    'usuario' => 'aceg.docent',
                    'estado' => true,
                    'password' => '$2y$10$JV4U.EfcQgNPGPPmRjmnu.D7q0wWRoFlK.4DIFpxfnnubza.hF7Hm',
                    'creado' => $miTiempo,
                    'modificado' => $miTiempo,
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
        Schema::dropIfExists('users');
    }
}
