<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('added_by', 6)->nullable();
            $table->integer('currency_id')->nullable();
            $table->double('price', 20, 2)->default(0.00);
            $table->double('discount', 20, 2)->nullable();
            $table->string('discount_type', 10)->nullable();
            $table->integer('variation_id')->nullable();
            $table->integer('todays_deal')->nullable();
            $table->integer('num_of_sale')->nullable();
            $table->integer('delivery_group_id')->nullable();
            $table->integer('qty')->default(0);
            $table->integer('published')->default(0);
            $table->double('tax', 20, 2)->nullable();
            $table->string('tax_type', 10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('featured')->default(0);
            $table->integer('seller_featured')->default(0);
            $table->boolean('on_moderation')->default(0);
            $table->boolean('is_accepted')->default(1);
            $table->double('rating', 8, 2)->default(0.00);
            $table->string('barcode', 255)->nullable();
            $table->double('earn_point', 8, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
