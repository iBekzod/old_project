<?php



use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('languages')->delete();

        \DB::table('languages')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'English',
                'code' => 'en',
                'rtl' => 0,
                'created_at' => '2019-01-20 17:13:20',
                'updated_at' => '2019-01-20 17:13:20',
            ),
            1 =>
            array (
                'id' => 3,
                'name' => 'Bangla',
                'code' => 'bd',
                'rtl' => 0,
                'created_at' => '2019-02-17 11:35:37',
                'updated_at' => '2019-02-18 11:49:51',
            ),
            2 =>
            array (
                'id' => 4,
                'name' => 'Arabic',
                'code' => 'sa',
                'rtl' => 1,
                'created_at' => '2019-04-28 23:34:12',
                'updated_at' => '2019-04-28 23:34:12',
            ),
        ));


    }
}
