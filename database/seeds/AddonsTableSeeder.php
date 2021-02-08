<?php

use Illuminate\Database\Seeder;

class AddonsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('addons')->delete();

        \DB::table('addons')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Point of Sale',
                'unique_identifier' => 'pos_system',
                'version' => '1.2',
                'activated' => 1,
                'image' => 'pos_banner.jpg',
                'created_at' => '2021-01-25 09:39:14',
                'updated_at' => '2021-01-26 06:38:22',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'affiliate',
                'unique_identifier' => 'affiliate_system',
                'version' => '1.2',
                'activated' => 1,
                'image' => 'affiliate_banner.jpg',
                'created_at' => '2021-01-25 06:50:00',
                'updated_at' => '2021-01-25 06:50:00',
            ),
        ));


    }
}
