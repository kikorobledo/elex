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
        Schema::create('referidos', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('sexo');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('domicilio');
            $table->string('colonia');
            $table->integer('cp');
            $table->string('municipio');
            $table->foreignId('seccion_id')->constrained();
            $table->string('clave_electoral')->unique();
            $table->string('imagen')->nullable();
            $table->foreignId('referente_id')->references('id')->on('referentes');
            $table->foreignId('candidato_id')->references('id')->on('users');
            $table->foreignId('creado_por')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referidos');
    }
};
