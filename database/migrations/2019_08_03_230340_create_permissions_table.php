<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('permission_type');
            $table->string('group');
            $table->string('type');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('permission_property_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('property_user_id');
            $table->bigInteger('permission_id');
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
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_property_user');
    }
}
