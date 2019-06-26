<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('subjectable_id')->index();
            $table->string('subjectable_type');
            $table->text('title')->nullable();    
            $table->text('message');
            $table->text('data')->nullable();
            $table->timestamps();
        });

        Schema::create('alertables', function (Blueprint $table) {
            $table->bigInteger('alert_id')->index();
            $table->bigInteger('alertable_id')->index();
            $table->string('alertable_type');
            $table->timestamps();
            $table->unique(['alert_id', 'alertable_id', 'alertable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alerts');
    }
}
