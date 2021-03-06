<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('approved_by')->nullable()->index();
            $table->bigInteger('property_id')->index();
            $table->integer('status_id')->default(2)->index();
            $table->bigInteger('job_order_id')->index()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('uploaderData')->nullable();
            $table->text('raw')->nullable();
            $table->timestamps();
        });

        Schema::create('job_order_job_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('job_request_id')->index();
            $table->bigInteger('job_order_id')->index();
            $table->bigInteger('status_id')->default(1)->index();
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
        Schema::dropIfExists('job_requests');
        Schema::dropIfExists('job_order_job_request');
    }
}
