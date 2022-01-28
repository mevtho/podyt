<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36);
            $table->foreignId('feed_id')->constrained();
            $table->string('title', 400);
            $table->string('slug', 400);
            $table->string('source_url', 400);
            $table->integer('duration')->default(0);
            $table->integer('mp3_access_count')->default(0);
            $table->enum('mp3_location_type', ["path","url"])->nullable();
            $table->string('mp3_location', 400)->nullable();
            $table->string('picture_url', 400)->nullable();
            $table->enum('status', ["pending","processing", "converted","published","failed"]);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}
