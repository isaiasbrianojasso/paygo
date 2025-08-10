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
        Schema::create('integration_credentials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Relación con users (bigint por default en Laravel)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Datos requeridos
            $table->string('url_webhook', 2048);
            $table->string('chat_id', 128);

            // API key/secret opcionales
            $table->string('api_key_hash', 255)->nullable();
            $table->char('api_key_sha256', 64)->nullable()->unique();

            // Cifrados (casts encrypted manejan null sin problema)
            $table->text('api_key_enc')->nullable();
            $table->text('api_secret_enc')->nullable();

            // Metadatos
            $table->unsignedSmallInteger('key_version')->default(1);
            $table->string('last4', 8)->nullable();

            $table->timestampsTz();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration_credentials');
    }
};
