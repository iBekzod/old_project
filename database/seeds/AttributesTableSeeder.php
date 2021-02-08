<?php

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('attributes')->delete();

        \DB::table('attributes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Size',
                'created_at' => '2020-02-24 10:55:07',
                'updated_at' => '2020-02-24 10:55:07',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Fabric',
                'created_at' => '2020-02-24 10:55:13',
                'updated_at' => '2020-02-24 10:55:13',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Camera',
                'created_at' => '2021-01-25 07:50:03',
                'updated_at' => '2021-01-25 07:50:03',
            ),
        ));


    }
}
