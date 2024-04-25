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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);
            $table->enum('file', ['Comprobante', 'Boleta', 'Factura'])->default('Comprobante');
            $table->enum('status', ['Pendiente', 'Listo', 'Entregado', 'Cancelado'])->default('Pendiente');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('client_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('delivery_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('grocer_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->enum('pay_type', ['Efectivo', 'Transferencia', 'Depósito', 'A crédito'])->nullable()->default(null);
            $table->decimal('payed')->nullable()->default(null);
            $table->decimal('rest')->nullable()->default(null);
            $table->string('card_number')->nullable()->default(null);
            $table->string('annex')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
