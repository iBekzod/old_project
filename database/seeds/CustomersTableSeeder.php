<?php



use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('customers')->delete();

        \DB::table('customers')->insert(array (
            0 =>
            array (
                'id' => 4,
                'user_id' => 8,
                'created_at' => '2019-08-01 15:35:09',
                'updated_at' => '2019-08-01 15:35:09',
            ),
        ));


    }
}
