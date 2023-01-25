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
        Schema::create('municipios', function (Blueprint $table) {
            $table->unsignedInteger('cod_ibge');
            $table->string('nome', 50);
            $table->unsignedTinyInteger('estado_cod_ibge');
            $table->timestamps();

            // Foreign key
            $table->foreign('estado_cod_ibge')->references('cod_ibge')->on('estados');
            // Indexs
            $table->primary('cod_ibge');
            $table->index('estado_cod_ibge');
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
        Schema::dropIfExists('municipios');
    }
};
