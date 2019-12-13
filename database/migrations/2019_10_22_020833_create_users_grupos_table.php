<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_grupo', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned();
            $table->foreign('grupo_id')
                ->references('id')->on('grupos');

            // $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')
            //     ->references('id')->on('users');

            $table->string('user_username');
            $table->foreign('user_username')
                ->references('username')->on('users');

            $table->index('user_username');
            $table->index('grupo_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_grupos');
    }
}
