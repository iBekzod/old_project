<?php



use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('sliders')->delete();

        \DB::table('sliders')->insert(array (
            0 =>
            array (
                'id' => 7,
                'photo' => 'uploads/sliders/slider-image.jpg',
                'published' => 1,
                'link' => NULL,
                'created_at' => '2019-03-12 10:58:05',
                'updated_at' => '2019-03-12 10:58:05',
            ),
            1 =>
            array (
                'id' => 8,
                'photo' => 'uploads/sliders/slider-image.jpg',
                'published' => 1,
                'link' => NULL,
                'created_at' => '2019-03-12 10:58:12',
                'updated_at' => '2019-03-12 10:58:12',
            ),
        ));


    }
}
