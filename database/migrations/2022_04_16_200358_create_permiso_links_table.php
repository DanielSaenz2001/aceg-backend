<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_links', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('link_id');
            $table->unsignedInteger('permiso_id');

            $table->foreign('permiso_id')->references('id')->on('permisos');
            $table->foreign('link_id')->references('id')->on('links');

            $table->unique(['link_id', 'permiso_id']);
            
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::table('permiso_links')->insert(
            [
                [ //1
                    'link_id' => 2,
                    'permiso_id' => 1,
                ],
                [ //2
                    'link_id' => 3,
                    'permiso_id' => 2,
                ],
                [ //3
                    'link_id' => 4,
                    'permiso_id' => 3,
                ],
                [ //4
                    'link_id' => 6,
                    'permiso_id' => 4,
                ],
                [ //5
                    'link_id' => 7,
                    'permiso_id' => 5,
                ],
                [ //6
                    'link_id' => 8,
                    'permiso_id' => 6,
                ],
                [ //7
                    'link_id' => 9,
                    'permiso_id' => 7,
                ],
                [ //8
                    'link_id' => 10,
                    'permiso_id' => 8,
                ],
                [ //9
                    'link_id' => 11,
                    'permiso_id' => 9,
                ],
                [ //10
                    'link_id' => 13,
                    'permiso_id' => 10,
                ],
                [ //11
                    'link_id' => 14,
                    'permiso_id' => 11,
                ],
                [ //12
                    'link_id' => 15,
                    'permiso_id' => 12,
                ],
                [ //13
                    'link_id' => 16,
                    'permiso_id' => 14,
                ],
                [ //14
                    'link_id' => 17,
                    'permiso_id' => 16,
                ],
                [ //15
                    'link_id' => 18,
                    'permiso_id' => 17,
                ],
                [ //16
                    'link_id' => 19,
                    'permiso_id' => 18,
                ],
                [ //17
                    'link_id' => 20,
                    'permiso_id' => 19,
                ],
                [ //18
                    'link_id' => 22,
                    'permiso_id' => 15,
                ],
                [ //19
                    'link_id' => 24,
                    'permiso_id' => 13,
                ],
                [ //20
                    'link_id' => 25,
                    'permiso_id' => 13,
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
        Schema::dropIfExists('permiso_links');
    }
}
