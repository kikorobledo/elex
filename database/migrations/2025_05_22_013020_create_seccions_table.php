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
        Schema::create('seccions', function (Blueprint $table) {
            $table->id();
            $table->string('distrito_federal');
            $table->string('distrito_local');
            $table->string('municipio');
            $table->string('localidad');
            $table->string('seccion');
            $table->string('casilla');
            $table->text('ubicacion');
            $table->string('presidente');
            $table->string('secretario_1');
            $table->string('secretario_2');
            $table->string('escrutador_1');
            $table->string('escrutador_2');
            $table->string('escrutador_3');
            $table->string('escrutador_4');
            $table->string('escrutador_5');
            $table->string('escrutador_6');
            $table->string('suplente_1');
            $table->string('suplente_2');
            $table->string('suplente_3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seccions');
    }
};
