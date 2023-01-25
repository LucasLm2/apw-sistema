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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf', 11)->nullable();
            $table->string('telefone', 11);
            $table->unsignedBigInteger('endereco_id')->nullable();
            $table->timestamps();
            
            // Foreign key
            $table->foreign('endereco_id')->references('id')->on('enderecos');

            //Indexs
            $table->unique('cpf');
            $table->index('endereco_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
