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
        Schema::create('i_p_s', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip')->nulled();
           // $table->string( 'user_id')->nulled();
            $table->string('nombre_servicio')->nulled();
            $table->string('descripcion_servicio')->nulled();
            $table->string('imagen')->nulled();
            $table->string('costo')->nulled();
            $table->string('service')->nullable();
            $table->date('fecha_inicio')->nulled();
            $table->date('fecha_final')->nulled();
            $table->boolean('autorizado')->nulled();
            $table->boolean( 'sync')->nulled();
            $table->boolean('borrado')->nulled();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_p_s');
    }
};
