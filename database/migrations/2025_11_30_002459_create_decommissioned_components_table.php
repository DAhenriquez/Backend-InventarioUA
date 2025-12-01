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
    Schema::create('decommissioned_components', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('imagen')->nullable();
        $table->text('descripcion')->nullable();
        $table->integer('cantidad');
        $table->string('inventario');
        $table->string('motivo'); // Ej: "Quemado", "No devuelto"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decommissioned_components');
    }
};
