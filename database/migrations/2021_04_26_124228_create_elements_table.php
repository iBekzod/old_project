<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200)->index('name');
            $table->string('added_by', 6)->default('admin');
            $table->integer('user_id');
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('photos', 2000)->nullable();
            $table->string('thumbnail_img', 100)->nullable();
            $table->string('video_provider', 20)->nullable();
            $table->string('video_link', 100)->nullable();
            $table->string('tags', 1000)->nullable()->index('tags');
            $table->longText('description')->nullable();
            $table->string('attributes', 1000)->default('[]');
            $table->mediumText('choice_options')->nullable();
            $table->mediumText('characteristics')->nullable();
            $table->mediumText('colors')->nullable();
            $table->integer('todays_deal')->default(0);
            $table->integer('published')->default(1);
            $table->integer('featured')->default(0);
            $table->string('unit', 20)->nullable();
            $table->integer('min_qty')->default(1);
            $table->integer('num_of_sale')->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_img', 255)->nullable();
            $table->string('pdf', 255)->nullable();
            $table->mediumText('slug');
            $table->integer('refundable')->default(0);
            $table->double('earn_point', 8, 2)->default(0.00);
            $table->double('rating', 8, 2)->default(0.00);
            $table->string('barcode', 255)->nullable();
            $table->integer('digital')->default(0);
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('on_moderation')->default(0);
            $table->boolean('is_accepted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elements');
    }
}
