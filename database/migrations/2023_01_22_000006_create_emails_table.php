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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('tabela_referencia');
            $table->unsignedBigInteger('referencia_id');
            $table->string('email');
            $table->string('nome_contato')->nullable();
            $table->timestamps();

            // Foreign keys

            // Indexs
            $table->index('tabela_referencia');
            $table->index('referencia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
