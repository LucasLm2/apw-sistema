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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 8);
            $table->unsignedInteger('municipio_cod_ibge');
            $table->unsignedInteger('bairro_id')->nullable();
            $table->unsignedInteger('rua_id')->nullable();
            $table->string('numero', 7)->nullable();
            $table->string('complemento')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('municipio_cod_ibge')->references('cod_ibge')->on('municipios');
            $table->foreign('bairro_id')->references('id')->on('bairros');
            $table->foreign('rua_id')->references('id')->on('ruas');
            // Indexs
            $table->index('municipio_cod_ibge');
            $table->index('bairro_id');
            $table->index('rua_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
};
