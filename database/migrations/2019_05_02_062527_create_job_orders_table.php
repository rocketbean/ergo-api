<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('job_request_id')->index();
            $table->bigInteger('supplier_id')->index();
            $table->bigInteger('property_id')->index();
            $table->bigInteger('status_id')->default(2);
            $table->decimal('estimation', 8, 2);
            $table->integer('view')->default(2);
            $table->text('remarks');
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
        Schema::dropIfExists('job_orders');
    }
}
