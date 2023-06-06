<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('hardware_models', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('repairs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('software_models', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('utilizations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('writeoffs', function (Blueprint $table) {
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
        Schema::table('departments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('hardware_models', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('repairs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('software_models', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('utilizations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('writeoffs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
