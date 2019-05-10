<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('filename');
            $table->string('ext');
            $table->string('thumb');
            $table->text('path');
            $table->datetime('converted_for_downloading_at')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
            $table->timestamps();
        });

        Schema::create('videoables', function (Blueprint $table) {
            $table->bigInteger('video_id')->index();
            $table->bigInteger('videoable_id')->index();
            $table->string('videoable_type');
            $table->timestamps();
            $table->unique(['video_id', 'videoable_id', 'videoable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
        Schema::dropIfExists('videoables');
    }
}
