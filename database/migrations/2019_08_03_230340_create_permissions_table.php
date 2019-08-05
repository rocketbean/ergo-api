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
            $table->string('slug');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('permission_property_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('property_user_id');
            $table->bigInteger('permission_id');
            $table->timestamps();
            $table->unique(['property_user_id', 'permission_id']);
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id');
            $table->bigInteger('permission_id');
            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);
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
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permission_property_user');
    }
}
