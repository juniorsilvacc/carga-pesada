<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('cidade_saida');
            $table->string('cidade_destino');
            $table->string('estado_saida');
            $table->string('estado_destino');
            $table->unsignedInteger('peso_carga');
            $table->date('data_viagem');
            $table->foreignUuid('motorista_id')->constrained('drivers')->onDelete('cascade');
            $table->foreignUuid('caminhao_id')->constrained('trucks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
