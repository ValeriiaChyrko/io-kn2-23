<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('departments');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers');
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->foreign('software_model_id')->references('id')->on('software_models');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('owner_id')->references('id')->on('users');
        });

        Schema::table('repairs', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('providers');
        });

        Schema::table('utilizations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('providers');
        });

        Schema::table('writeoffs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('part_of')->references('id')->on('items');
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('hardware_model_id')->references('id')->on('hardware_models');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('writeoff_id')->references('id')->on('writeoffs');
            $table->foreign ('utilization_id')->references('id')->on('utilizations');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
