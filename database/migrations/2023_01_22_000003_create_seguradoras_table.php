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
        Schema::create('seguradoras', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 14);
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->string('site')->nullable();
            $table->unsignedBigInteger('endereco_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            // Foreign keys
            $table->foreign('endereco_id')->references('id')->on('enderecos');

            // Indexs
            $table->unique('cnpj');
            $table->index('endereco_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguradoras');
    }
};
