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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('rut')->unique(); // El identificador principal
        $table->string('nombre');
        $table->string('apellido');
        
        // Estos ahora pueden estar vacíos para los alumnos
        $table->string('email')->unique()->nullable(); 
        $table->string('password')->nullable();
        
        // Esto define si puede entrar a la web o no
        $table->boolean('is_admin')->default(false); 
        
        $table->timestamps();
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
