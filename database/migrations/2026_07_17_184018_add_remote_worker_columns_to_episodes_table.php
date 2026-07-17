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
        Schema::table('episodes', function (Blueprint $table) {
            $table->unsignedBigInteger('workflow_id')->nullable()->after('status');
            $table->timestamp('claimed_at')->nullable()->after('workflow_id');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->enum('status', ["pending", "processing", "downloaded", "transcribed", "answered", "published", "failed", "queued_remote"])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn(['workflow_id', 'claimed_at']);
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->enum('status', ["pending", "processing", "downloaded", "transcribed", "answered", "published", "failed"])->change();
        });
    }
};
