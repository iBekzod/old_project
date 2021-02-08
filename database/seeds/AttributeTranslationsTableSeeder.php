<?php



use Illuminate\Database\Seeder;

class AttributeTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('attribute_translations')->delete();

        \DB::table('attribute_translations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'attribute_id' => 3,
                'name' => 'Camera',
                'lang' => 'bd',
                'created_at' => '2021-01-25 07:50:03',
                'updated_at' => '2021-01-25 07:50:03',
            ),
        ));


    }
}
