<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 50);
            $table->unsignedInteger('bairro_id');
            $table->timestamps();

            // Foreign key
            $table->foreign('bairro_id')->references('id')->on('bairros');
            // Indexs
            $table->index('bairro_id');
            $table->index('nome');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruas');
    }
};
