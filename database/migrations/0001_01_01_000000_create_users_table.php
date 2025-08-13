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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string(  'email')->unique();
            $table->string(  'telegram')->unique()->nullable();
            $table->string(  'telefono')->unique()->nullable();
            $table->float( 'creditos')->nullable();
            $table->float( 'borrado')->nullable();
            $table->float(  'habilitado')->nullable()->value(0);
            $table->date( 'fecha_inicio')->nullable();
            $table->date( 'fecha_final')->nullable();
            $table->string('api_key')->unique()->nullable();
            $table->string( 'api_token')->unique()->nullable();
            $table->integer('reputacion')->nullable()->value(null);
            $table->string( 'binance_address')->unique()->nullable();//binance_id
            $table->string( 'BINANCE_API_KEY')->unique()->nullable();//binance api
            $table->string( 'BINANCE_SECRET_KEY')->unique()->nullable();//binance secret
            $table->timestamp('email_verified_at')->nullable();
            $table->string( 'password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
