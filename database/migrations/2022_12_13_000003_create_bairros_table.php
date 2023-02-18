<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bairros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 50);
            $table->unsignedInteger('municipio_cod_ibge');
            $table->timestamps();

            // Foreign key
            $table->foreign('municipio_cod_ibge')->references('cod_ibge')->on('municipios');
            // Indexs
            $table->index('municipio_cod_ibge');
            $table->index('nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bairros');
    }
};
