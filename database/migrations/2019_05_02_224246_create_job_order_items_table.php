<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('job_order_id')->index();
            $table->bigInteger('job_request_item_id')->index();
            $table->integer('status_id')->default(1);
            $table->bigInteger('job_request_id')->index();
            $table->bigInteger('property_id')->index();
            $table->bigInteger('supplier_id')->index();
            $table->text('remarks');
            $table->float('amount', 8, 2);
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
        Schema::dropIfExists('job_order_items');
    }
}
