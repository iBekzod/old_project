<?php

use Illuminate\Database\Seeder;

class AppSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('app_settings')->delete();

        \DB::table('app_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Team EStore',
                'logo' => 'uploads/logo/matggar.png',
                'currency_id' => 1,
                'currency_format' => 'symbol',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'instagram' => 'https://instagram.com',
                'youtube' => 'https://youtube.com',
                'google_plus' => 'https://google.com',
                'created_at' => '2019-08-04 21:39:15',
                'updated_at' => '2019-08-04 21:39:18',
            ),
        ));


    }
}
