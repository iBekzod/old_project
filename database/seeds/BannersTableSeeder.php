<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('banners')->delete();

        \DB::table('banners')->insert(array (
            0 =>
            array (
                'id' => 4,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 1,
                'published' => 1,
                'created_at' => '2019-03-12 10:58:23',
                'updated_at' => '2019-06-11 09:56:50',
            ),
            1 =>
            array (
                'id' => 5,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 1,
                'published' => 1,
                'created_at' => '2019-03-12 10:58:41',
                'updated_at' => '2019-03-12 10:58:57',
            ),
            2 =>
            array (
                'id' => 6,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 2,
                'published' => 1,
                'created_at' => '2019-03-12 10:58:52',
                'updated_at' => '2019-03-12 10:58:57',
            ),
            3 =>
            array (
                'id' => 7,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 2,
                'published' => 1,
                'created_at' => '2019-05-26 10:16:38',
                'updated_at' => '2019-05-26 10:17:34',
            ),
            4 =>
            array (
                'id' => 8,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 2,
                'published' => 1,
                'created_at' => '2019-06-11 10:00:06',
                'updated_at' => '2019-06-11 10:00:27',
            ),
            5 =>
            array (
                'id' => 9,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 1,
                'published' => 1,
                'created_at' => '2019-06-11 10:00:15',
                'updated_at' => '2019-06-11 10:00:29',
            ),
            6 =>
            array (
                'id' => 10,
                'photo' => 'uploads/banners/banner.jpg',
                'url' => '#',
                'position' => 1,
                'published' => 0,
                'created_at' => '2019-06-11 10:00:24',
                'updated_at' => '2019-06-11 10:01:56',
            ),
        ));


    }
}
