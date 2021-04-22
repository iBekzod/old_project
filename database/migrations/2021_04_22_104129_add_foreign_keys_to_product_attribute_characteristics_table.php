<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductAttributeCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_attribute_characteristics', function (Blueprint $table) {
            $table->foreign('attribute_id', 'product_attribute_characteristics_ibfk_1')->references('id')->on('product_attributes')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_attribute_characteristics', function (Blueprint $table) {
            $table->dropForeign('product_attribute_characteristics_ibfk_1');
        });
    }
}
