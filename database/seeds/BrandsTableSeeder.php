<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('brands')->delete();

        \DB::table('brands')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Demo brand',
                'logo' => 'uploads/brands/brand.jpg',
                'top' => 1,
                'slug' => 'Demo-brand-12',
                'meta_title' => 'Demo brand',
                'meta_description' => NULL,
                'created_at' => '2019-03-12 11:05:56',
                'updated_at' => '2019-08-06 11:52:40',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Demo brand1',
                'logo' => 'uploads/brands/brand.jpg',
                'top' => 1,
                'slug' => 'Demo-brand1',
                'meta_title' => 'Demo brand1',
                'meta_description' => NULL,
                'created_at' => '2019-03-12 11:06:13',
                'updated_at' => '2019-08-06 11:07:26',
            ),
        ));


    }
}
