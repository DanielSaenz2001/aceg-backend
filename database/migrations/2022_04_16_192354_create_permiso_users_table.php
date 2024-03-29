<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_users', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('permiso_id');
            $table->unsignedInteger('user_id');

            $table->foreign('permiso_id')->references('id')->on('permisos');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(['user_id', 'permiso_id']);
            
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('permiso_users')->insert(
            [
                [//1
                    'user_id' => 1,
                    'permiso_id' => 1,
                ],
                [//2
                    'user_id' => 1,
                    'permiso_id' => 2,
                ],
                [//3
                    'user_id' => 1,
                    'permiso_id' => 3,
                ],
                [//4
                    'user_id' => 1,
                    'permiso_id' => 4,
                ],
                [//5
                    'user_id' => 1,
                    'permiso_id' => 5,
                ],
                [//6
                    'user_id' => 1,
                    'permiso_id' => 6,
                ],
                [//7
                    'user_id' => 1,
                    'permiso_id' => 7,
                ],
                [//8
                    'user_id' => 1,
                    'permiso_id' => 8,
                ],
                [//9
                    'user_id' => 1,
                    'permiso_id' => 9,
                ],
                [//10
                    'user_id' => 2,
                    'permiso_id' => 10,
                ],
                [//11
                    'user_id' => 2,
                    'permiso_id' => 11,
                ],
                [//12
                    'user_id' => 2,
                    'permiso_id' => 12,
                ],
                [//13
                    'user_id' => 3,
                    'permiso_id' => 13,
                ],
                [//13
                    'user_id' => 1,
                    'permiso_id' => 14,
                ],
                [//14
                    'user_id' => 4,
                    'permiso_id' => 15,
                ],
                [//15
                    'user_id' => 2,
                    'permiso_id' => 16,
                ],
                [//16
                    'user_id' => 3,
                    'permiso_id' => 17,
                ],
                [//17
                    'user_id' => 2,
                    'permiso_id' => 18,
                ],
                [//18
                    'user_id' => 2,
                    'permiso_id' => 19,
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
        Schema::dropIfExists('permiso_users');
    }
}
