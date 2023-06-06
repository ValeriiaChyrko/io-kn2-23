<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->date('date')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->text('file_url');
            $table->boolean('confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilizations');
    }
}
