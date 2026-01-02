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
        // 1. Add user_id to expenses
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });

        // 2. Add user_id to settings + adjust constraints
        Schema::table('settings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Drop old simple unique constraint on 'key'
            $table->dropUnique('settings_key_unique');
            
            // Add new composite unique constraint (key + user_id)
            $table->unique(['key', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['key', 'user_id']);
            $table->dropColumn('user_id');
            // Re-adding unique 'key' might fail if duplicates exist now, but for rollback we try:
            $table->unique('key');
        });
    }
};
