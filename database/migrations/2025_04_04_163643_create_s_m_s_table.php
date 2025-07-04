<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('s_m_s', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('number')->nullable();
            $table->string('sender')->nullable();
            $table->string('api_id')->nullable();
            $table->string('msj')->nullable();
            $table->boolean('status')->nullable();
            $table->integer( 'sender_id')->nullable();
            $table->float('costo')->nullable();
            $table->string('sender_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_m_s');
    }
};
