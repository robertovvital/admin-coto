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
        Schema::create('residentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coto_id')->constrained('cotos')->onDelete('cascade');
            $table->string('nombre');
            $table->string('casa');
            $table->string('contacto')->nullable();
            $table->string('email')->unique();
            // Datos internacionales (API REST Countries)
            $table->string('pais')->nullable();
            $table->string('pais_codigo')->nullable();
            $table->string('capital')->nullable();
            $table->string('moneda')->nullable();
            $table->string('idioma')->nullable();
            $table->string('zona_horaria')->nullable();
            $table->string('bandera_url')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residentes');
    }
};
