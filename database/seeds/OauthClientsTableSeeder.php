<?php



use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('oauth_clients')->delete();

        \DB::table('oauth_clients')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => NULL,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'eR2y7WUuem28ugHKppFpmss7jPyOHZsMkQwBo1Jj',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2019-07-13 11:17:34',
                'updated_at' => '2019-07-13 11:17:34',
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => NULL,
                'name' => 'Laravel Password Grant Client',
                'secret' => 'WLW2Ol0GozbaXEnx1NtXoweYPuKEbjWdviaUgw77',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2019-07-13 11:17:34',
                'updated_at' => '2019-07-13 11:17:34',
            ),
        ));


    }
}
