\<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->string('description')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();
        });

        Schema::create('roleables', function (Blueprint $table) {
            $table->bigInteger('role_id')->index();
            $table->bigInteger('roleable_id')->index();
            $table->string('roleable_type');
            $table->timestamps();
            $table->unique(['role_id', 'roleable_id', 'roleable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('roleables');
    }
}
