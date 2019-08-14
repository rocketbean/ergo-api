<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_request_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->integer('status_id')->default(1);
            $table->bigInteger('property_id')->index();
            $table->bigInteger('job_request_id')->index();
            $table->bigInteger('job_order_item_id')->nullable()->index();
            $table->string('name');
            $table->text('uploaderData');
            $table->text('description');
            $table->timestamps();
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_request_items');
    }
}
