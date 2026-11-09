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
        Schema::create('agendamentos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('barbeiro_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('corte_id')->constrained('cortes')->onDelete('cascade'); 
    $table->dateTime('data_hora');
    $table->string('status')->default('pendente'); // pendente, confirmado, cancelado
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
