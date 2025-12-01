<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        $table->string('user_rut'); // Referencia al RUT del usuario
        $table->foreignId('component_id')->constrained('components'); // Relación con ID del componente
        $table->integer('cantidad');
        $table->text('comentario')->nullable();
        $table->string('estado')->default('activo'); // 'activo' o 'devuelto'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
