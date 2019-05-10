<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('filename');
            $table->string('ext');
            $table->text('path');
            $table->timestamps();
        });

        Schema::create('fileables', function (Blueprint $table) {
            $table->bigInteger('file_id')->index();
            $table->bigInteger('fileable_id')->index();
            $table->string('fileable_type');
            $table->timestamps();
            $table->unique(['file_id', 'fileable_id', 'fileable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('fileables');

    }
}
