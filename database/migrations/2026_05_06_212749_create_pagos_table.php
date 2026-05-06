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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residente_id')->constrained('residentes')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->date('periodo_mes'); // Mes al que corresponde el pago
            $table->enum('estado', ['pagado', 'pendiente', 'vencido'])->default('pagado');
            $table->string('metodo_pago')->nullable(); // efectivo, transferencia, etc.
            $table->text('notas')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
