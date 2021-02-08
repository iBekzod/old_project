<?php



use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('shops')->delete();

        \DB::table('shops')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 3,
                'name' => 'Demo Seller Shop',
                'logo' => NULL,
                'sliders' => NULL,
                'address' => 'House : Demo, Road : Demo, Section : Demo',
                'facebook' => 'www.facebook.com',
                'google' => 'www.google.com',
                'twitter' => 'www.twitter.com',
                'youtube' => 'www.youtube.com',
                'slug' => 'Demo-Seller-Shop-1',
                'meta_title' => 'Demo Seller Shop Title',
                'meta_description' => 'Demo description',
                'pick_up_point_id' => NULL,
                'shipping_cost' => 0.0,
                'created_at' => '2018-11-27 15:23:13',
                'updated_at' => '2019-08-06 11:43:16',
            ),
        ));


    }
}
