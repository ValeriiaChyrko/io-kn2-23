<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_transfer', function (Blueprint $table) {
            $table->integer('transfer_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->foreign('item_id')->references('id')->on('items');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_item_id_foreign');
            $table->renameColumn('item_id','transfer_number');    //TODO: Review
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_transfer');
    }
}
