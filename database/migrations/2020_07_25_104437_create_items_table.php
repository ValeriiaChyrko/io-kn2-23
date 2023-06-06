<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('hardware_model_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('owner_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('inventory_number')->nullable()->unique();
            $table->decimal('price')->nullable();
            $table->integer('invoice_id')->unsigned();
            $table->boolean('has_parts')->default(false);
            $table->integer('part_of')->unsigned()->nullable();
            $table->integer('writeoff_id')->unsigned()->nullable();
            $table->integer('utilization_id')->unsigned()->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
