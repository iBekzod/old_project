<?php



use Illuminate\Database\Seeder;

class SeoSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('seo_settings')->delete();

        \DB::table('seo_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'keyword' => 'bootstrap,responsive,template,developer',
                'author' => 'TeamPRO',
                'revisit' => 11,
                'sitemap_link' => 'https://teamprodev.com',
                'description' => 'Team EStore Multi vendor system is such a platform to build a border less marketplace both for physical and digital goods.',
                'created_at' => '2019-08-08 13:56:11',
                'updated_at' => '2019-08-08 07:56:11',
            ),
        ));


    }
}
