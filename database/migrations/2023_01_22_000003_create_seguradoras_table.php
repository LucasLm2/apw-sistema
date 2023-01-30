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
        Schema::create('seguradoras', function (Blueprint $table) {
            $table->id();
            $table->string('cpnj', 14);
            $table->string('nome');
            $table->string('inscricao_estadual')->nullable();
            $table->string('site')->nullable();
            $table->unsignedBigInteger('endereco_id')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('endereco_id')->references('id')->on('enderecos');

            // Indexs
            $table->unique('cpnj');
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
        Schema::dropIfExists('seguradoras');
    }
};
