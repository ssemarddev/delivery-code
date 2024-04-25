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
        Schema::create('client_payments', function (Blueprint $table) {
            $table->id();
            $table->enum('pay_type', ['Efectivo', 'Transferencia', 'Depósito', 'A crédito']);
            $table->enum('final_pay_type', ['Efectivo', 'Transferencia', 'Depósito'])->nullable()->default(null);
            $table->decimal('total')->nullable()->default(null);
            $table->decimal('rest')->nullable()->default(null);
            $table->string('card')->nullable()->default(null);
            $table->string('annex')->nullable()->default(null);
            $table->dateTime('pay_date')->nullable()->default(null);
            $table->foreignId('user_id')
                ->nullable()
                ->default(null)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->enum('status', ['Pagado', 'Por pagar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_payments');
    }
};
