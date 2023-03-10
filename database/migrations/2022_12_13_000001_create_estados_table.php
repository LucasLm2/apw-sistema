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
        Schema::create('estados', function (Blueprint $table) {
            $table->unsignedTinyInteger('cod_ibge');
            $table->string('uf', 2);
            $table->string('nome', 20);
            $table->timestamps();

            // Indexs
            $table->primary('cod_ibge');
            $table->unique('uf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
