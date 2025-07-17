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
        Schema::create('detalle_transaccions', function (Blueprint $table) {
            $table->id();
            $table->string('trx')->nullable();//transaccion ID
            $table->boolean('status')->nullable();//status
            $table->float('monto')->nullable();//monto
            $table->string('cuenta_origen')->nullable();//banco,entidad de origen dinero
            $table->string('cuenta_destino')->nullable();//banco,entidad de destino dinero
            $table->boolean('acreditado')->nullable();
            $table->string('token_auth')->nullable();
            $table->string('captura')->nullable();
            $table->string('moneda')->nullable(); // Expiration time for the token
            $table->foreignId('id_transaccion')->constrained('transaccions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_transaccions');
    }
};
