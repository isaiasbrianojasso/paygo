<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_transaccions', function (Blueprint $table) {
            $table->id();
            $table->string('transaccion_id')->nullable();//transaccion ID
            $table->float('monto_binance')->nullable();//monto
            $table->float('monto_usuario')->nullable();//monto
            $table->string('respuesta_binance')->nullable();//respuesta de la transaccion de binance

            $table->boolean('status')->nullable();//status
            $table->string('nombre_binance')->nullable();//banco,entidad de origen dinero
            $table->string('transaction_id_binance')->nullable();//banco,entidad de destino dinero
            $table->string('binance_id')->nullable();//banco,entidad de destino dinero


            $table->boolean('acreditado')->nullable();//indica si ya se canjeo el pago
            $table->string('captura_imagen')->nullable();
            $table->string('moneda')->nullable(); // Expiration time for the token
            $table->string('hash_imagen', 64)->nullable(); // Hash único de la imagen (SHA-256)

            $table->string('banco')->nullable(); // Expiration time for the token
            $table->string(column: 'identifier')->nullable(); // Expiration time for the token
            $table->string(column: 'servicio')->nullable(); // Expiration time for the token


            $table->string('tipo')->nullable(); // Tipo de transacción (ej. "transferencia", "pago", etc.)
            $table->string('referencia')->nullable(); // Referencia de la transacción
            $table->string('descripcion')->nullable(); // Des

            $table->string('token_auth')->nullable();
            $table->foreignId('id_transaccion')->constrained('transaccions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

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
