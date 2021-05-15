<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->integer('lowest_price_id')->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('partnum', 255)->nullable();
            $table->integer('element_id');
            $table->mediumText('prices')->nullable();
            $table->string('variant', 255)->nullable();
            $table->string('sku', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('user_id');
            $table->integer('num_of_sale')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variations');
    }
}
