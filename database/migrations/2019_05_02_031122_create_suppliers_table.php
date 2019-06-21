<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('location_id')->nullable()->index();
            $table->bigInteger('user_id')->index();
            $table->bigInteger('primary')->default(2)->index();
            $table->string('name');
            $table->string('status_id')->default(2)->index();
            $table->text('description')->nullable();
            $table->decimal('ratings', 8, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('supplier_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('supplier_id')->index();
            $table->bigInteger('role_id')->default(2)->index();
            $table->bigInteger('client_id')->index();
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
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('supplier_user');
    }
}
