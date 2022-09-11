<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanPeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_periodos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('periodo');
            $table->unsignedInteger('plan_academico_id');

            $table->foreign('plan_academico_id')->references('id')->on('plan_academico');
            
            $table->unique(['periodo', 'plan_academico_id']);

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
        
        DB::table('plan_periodos')->insert(
            [
                [//1
                    'periodo'           => '1',
                    'plan_academico_id' => 1,
                ],
                [//2
                    'periodo'           => '2',
                    'plan_academico_id' => 1,
                ],
                [//3
                    'periodo'             => '3',
                    'plan_academico_id' => 1,
                ],
                [//4
                    'periodo'           => '4',
                    'plan_academico_id' => 1,
                ],
            ]
        );
    }

    
    public function down()
    {
        Schema::dropIfExists('plan_ciclos');
    }
}
