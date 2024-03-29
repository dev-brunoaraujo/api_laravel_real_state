<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealStateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_state_categories', function (Blueprint $table) {
            $table->unsignedInteger('real_state_id');
            $table->unsignedInteger('category_id');

            $table->foreign('real_state_id')->references('id')->on('real_state');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_state_categories');
    }
}
