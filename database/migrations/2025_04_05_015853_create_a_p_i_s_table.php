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
        Schema::create('a_p_i_s', function (Blueprint $table) {
            $table->id('api_id');
            $table->string('url');
            $table->string('nombre');
            $table->string('parametro_1')->nullable();
            $table->string('valor_1')->nullable();
            $table->string('parametro_2')->nullable();
            $table->string('valor_2')->nullable();
            $table->string('parametro_3')->nullable();
            $table->string('valor_3')->nullable();
            $table->string('parametro_4')->nullable();
            $table->string('valor_4')->nullable();
            $table->string('parametro_5')->nullable();
            $table->string('valor_5')->nullable();
            $table->string('parametro_6')->nullable();
            $table->string('valor_6')->nullable();
            $table->string('parametro_7')->nullable();
            $table->string('valor_7')->nullable();
            $table->string('parametro_8')->nullable();
            $table->string('valor_8')->nullable();
            $table->string('parametro_9')->nullable();
            $table->string('valor_9')->nullable();
            $table->string('parametro_10')->nullable();
            $table->string('valor_10')->nullable();
            $table->string('parametro_api')->nullable();
            $table->string('valor_api')->nullable();

            $table->string('parametro_msg')->nullable();
            $table->string('valor_msg')->nullable();

            $table->string('parametro_number')->nullable();
            $table->string('valor_number')->nullable();
            $table->string('parametro_sender')->nullable();
            $table->string('valor_sender')->nullable();
            $table->string( 'parametro_token')->nullable();
            $table->string('valor_token')->nullable();
            $table->string('parametro_success')->nullable();
            $table->string('valor_success')->nullable();
            $table->boolean('borrado')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_p_i_s');
    }
};
