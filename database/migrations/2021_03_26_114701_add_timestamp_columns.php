<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('utilizations', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('writeoffs', function (Blueprint $table) {
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
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('utilizations', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('writeoffs', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
