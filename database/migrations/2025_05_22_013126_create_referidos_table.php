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
            $table->string('status')->default('nuevo');
            $table->string('sexo')->nullable();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('colonia')->nullable();
            $table->integer('cp')->nullable();
            $table->string('municipio')->nullable();
            $table->foreignId('seccion_id')->nullable();
            $table->string('clave_electoral')->nullable();
            $table->string('imagen')->nullable();
            $table->foreignId('referente_id')->references('id')->on('referentes');
            $table->foreignId('candidato_id')->references('id')->on('users');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
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
