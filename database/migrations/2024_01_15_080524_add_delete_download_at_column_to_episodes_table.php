<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->date('delete_download_at')->nullable()->after('mp3_location_type');
        });

        // Update the existing episodes (not many so we can do it this way)
        \App\Models\Episode::get()->each(function ($episode) {
            $episode->delete_download_at = $episode->created_at->addDays(7);
            $episode->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('delete_download_at');
        });
    }
};
