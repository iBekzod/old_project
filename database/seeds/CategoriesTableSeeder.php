<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('categories')->delete();

        \DB::table('categories')->insert(array (
            0 =>
            array (
                'id' => 1,
                'parent_id' => 0,
                'level' => 0,
                'name' => 'Demo category 1',
                'commision_rate' => 0.0,
                'banner' => 'uploads/categories/banner/category-banner.jpg',
                'icon' => 'uploads/categories/icon/KjJP9wuEZNL184XVUk3S7EiZ8NnBN99kiU4wdvp3.png',
                'featured' => 1,
                'top' => 1,
                'digital' => 0,
                'slug' => 'Demo-category-1',
                'meta_title' => 'Demo category 1',
                'meta_description' => NULL,
                'created_at' => '2019-08-06 17:06:58',
                'updated_at' => '2019-08-06 11:06:58',
            ),
            1 =>
            array (
                'id' => 2,
                'parent_id' => 0,
                'level' => 0,
                'name' => 'Demo category 2',
                'commision_rate' => 0.0,
                'banner' => 'uploads/categories/banner/category-banner.jpg',
                'icon' => 'uploads/categories/icon/h9XhWwI401u6sRoLITEk9SUMRAlWN8moGrpPfS6I.png',
                'featured' => 1,
                'top' => 0,
                'digital' => 0,
                'slug' => 'Demo-category-2',
                'meta_title' => 'Demo category 2',
                'meta_description' => NULL,
                'created_at' => '2019-08-06 17:06:58',
                'updated_at' => '2019-08-06 11:06:58',
            ),
            2 =>
            array (
                'id' => 3,
                'parent_id' => 0,
                'level' => 0,
                'name' => 'Demo category 3',
                'commision_rate' => 0.0,
                'banner' => 'uploads/categories/banner/category-banner.jpg',
                'icon' => 'uploads/categories/icon/rKAPw5rNlS84JtD9ZQqn366jwE11qyJqbzAe5yaA.png',
                'featured' => 1,
                'top' => 1,
                'digital' => 0,
                'slug' => 'Demo-category-3',
                'meta_title' => 'Demo category 3',
                'meta_description' => NULL,
                'created_at' => '2019-08-06 17:06:58',
                'updated_at' => '2019-08-06 11:06:58',
            ),
        ));


    }
}
