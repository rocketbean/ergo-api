<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('attachables', function (Blueprint $table) {
            $table->bigInteger('attachment_id')->index();
            $table->bigInteger('attachable_id')->index();
            $table->string('attachable_type');
            $table->timestamps();
            $table->unique(['attachment_id', 'attachable_id', 'attachable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('attachments');
    }
}
