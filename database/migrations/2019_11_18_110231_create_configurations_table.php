<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');

            $table->integer('grupo_id')->unsigned();
            $table->foreign('grupo_id')
                ->references('id')->on('grupos');

            $table->string('user_username');
            $table->foreign('user_username')
                ->references('username')->on('users');

            $table->integer('points_required');
            $table->integer('points_excahnge');
            $table->timestamps();
            $table->index('user_username');
            $table->index('grupo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
