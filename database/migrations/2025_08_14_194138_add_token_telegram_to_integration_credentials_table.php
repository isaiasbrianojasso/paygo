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
        Schema::table('integration_credentials', function (Blueprint $table) {
            $table->string('token_telegram')->nullable()->after('qr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('integration_credentials', function (Blueprint $table) {
            $table->dropColumn('token_telegram');
        });
    }
};
