<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36);
            $table->string('externalid');
            $table->foreignId('user_id')->constrained();
            $table->string('title', 400);
            $table->string('slug', 400);
            $table->string('cover_photo_path')->default('');
            $table->boolean('available')->default(true);
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
        Schema::dropIfExists('feeds');
    }
}
