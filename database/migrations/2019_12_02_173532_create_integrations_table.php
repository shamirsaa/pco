<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrations_service_manager', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->string('cerrado_por');
            $table->integer('cerrados')->nullable();
            $table->integer('cumplidos')->nullable();
            $table->double('cumplimiento')->nullable();
            $table->double('productividad')->nullable();
            $table->timestamp('carga')->nullable();
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
        Schema::dropIfExists('integrations_service_manager');
    }
}
