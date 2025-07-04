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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->string('call_sid')->unique()->nullable();
            $table->string('to')->nullable();
            $table->string('from')->nullable();
            $table->string( 'status')->nullable();
            $table->string(  'cost')->nullable();
            $table->string('status_callback')->nullable();
            $table->string('status_callback_method')->nullable();
            $table->string('url')->nullable();
            $table->string('recording_sid')->nullable();
            $table->string('recording_url')->nullable();
            $table->string('recording_duration')->nullable();
            $table->string('recording_status')->nullable();
            $table->string('recording_date')->nullable();
            $table->string('recording_format')->nullable();
            $table->string('recording_size')->nullable();
            $table->string( 'id_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
