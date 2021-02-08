<?php



use Illuminate\Database\Seeder;

class OauthAccessTokensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('oauth_access_tokens')->delete();

        \DB::table('oauth_access_tokens')->insert(array (
            0 =>
            array (
                'id' => '125ce8289850f80d9fea100325bf892fbd0deba1f87dbfc2ab81fb43d57377ec24ed65f7dc560e46',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => '2019-07-30 09:51:13',
                'updated_at' => '2019-07-30 09:51:13',
                'expires_at' => '2020-07-30 10:51:13',
            ),
            1 =>
            array (
                'id' => '293d2bb534220c070c4e90d25b5509965d23d3ddbc05b1e29fb4899ae09420ff112dbccab1c6f504',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 11:00:04',
                'updated_at' => '2019-08-04 11:00:04',
                'expires_at' => '2020-08-04 12:00:04',
            ),
            2 =>
            array (
                'id' => '5363e91c7892acdd6417aa9c7d4987d83568e229befbd75be64282dbe8a88147c6c705e06c1fb2bf',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => '2019-07-13 11:44:28',
                'updated_at' => '2019-07-13 11:44:28',
                'expires_at' => '2020-07-13 12:44:28',
            ),
            3 =>
            array (
                'id' => '681b4a4099fac5e12517307b4027b54df94cbaf0cbf6b4bf496534c94f0ccd8a79dd6af9742d076b',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 12:23:06',
                'updated_at' => '2019-08-04 12:23:06',
                'expires_at' => '2020-08-04 13:23:06',
            ),
            4 =>
            array (
                'id' => '6d229e3559e568df086c706a1056f760abc1370abe74033c773490581a042442154afa1260c4b6f0',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 12:32:12',
                'updated_at' => '2019-08-04 12:32:12',
                'expires_at' => '2020-08-04 13:32:12',
            ),
            5 =>
            array (
                'id' => '6efc0f1fc3843027ea1ea7cd35acf9c74282f0271c31d45a164e7b27025a315d31022efe7bb94aaa',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 0,
                'created_at' => '2019-08-08 07:35:26',
                'updated_at' => '2019-08-08 07:35:26',
                'expires_at' => '2020-08-08 08:35:26',
            ),
            6 =>
            array (
                'id' => '7745b763da15a06eaded371330072361b0524c41651cf48bf76fc1b521a475ece78703646e06d3b0',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 12:29:44',
                'updated_at' => '2019-08-04 12:29:44',
                'expires_at' => '2020-08-04 13:29:44',
            ),
            7 =>
            array (
                'id' => '815b625e239934be293cd34479b0f766bbc1da7cc10d464a2944ddce3a0142e943ae48be018ccbd0',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-07-22 07:07:47',
                'updated_at' => '2019-07-22 07:07:47',
                'expires_at' => '2020-07-22 08:07:47',
            ),
            8 =>
            array (
                'id' => '8921a4c96a6d674ac002e216f98855c69de2568003f9b4136f6e66f4cb9545442fb3e37e91a27cad',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 11:05:05',
                'updated_at' => '2019-08-04 11:05:05',
                'expires_at' => '2020-08-04 12:05:05',
            ),
            9 =>
            array (
                'id' => '8d8b85720304e2f161a66564cec0ecd50d70e611cc0efbf04e409330086e6009f72a39ce2191f33a',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 11:44:35',
                'updated_at' => '2019-08-04 11:44:35',
                'expires_at' => '2020-08-04 12:44:35',
            ),
            10 =>
            array (
                'id' => 'bcaaebdead4c0ef15f3ea6d196fd80749d309e6db8603b235e818cb626a5cea034ff2a55b66e3e1a',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 12:14:32',
                'updated_at' => '2019-08-04 12:14:32',
                'expires_at' => '2020-08-04 13:14:32',
            ),
            11 =>
            array (
                'id' => 'c25417a5c728073ca8ba57058ded43d496a9d2619b434d2a004dd490a64478c08bc3e06ffc1be65d',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-07-30 06:45:31',
                'updated_at' => '2019-07-30 06:45:31',
                'expires_at' => '2020-07-30 07:45:31',
            ),
            12 =>
            array (
                'id' => 'c7423d85b2b5bdc5027cb283be57fa22f5943cae43f60b0ed27e6dd198e46f25e3501b3081ed0777',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-05 10:02:59',
                'updated_at' => '2019-08-05 10:02:59',
                'expires_at' => '2020-08-05 11:02:59',
            ),
            13 =>
            array (
                'id' => 'e76f19dbd5c2c4060719fb1006ac56116fd86f7838b4bf74e2c0a0ac9696e724df1e517dbdb357f4',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-07-15 07:53:40',
                'updated_at' => '2019-07-15 07:53:40',
                'expires_at' => '2020-07-15 08:53:40',
            ),
            14 =>
            array (
                'id' => 'ed7c269dd6f9a97750a982f62e0de54749be6950e323cdfef892a1ec93f8ddbacf9fe26e6a42180e',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-07-13 11:36:45',
                'updated_at' => '2019-07-13 11:36:45',
                'expires_at' => '2020-07-13 12:36:45',
            ),
            15 =>
            array (
                'id' => 'f6d1475bc17a27e389000d3df4da5c5004ce7610158b0dd414226700c0f6db48914637b4c76e1948',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 12:22:01',
                'updated_at' => '2019-08-04 12:22:01',
                'expires_at' => '2020-08-04 13:22:01',
            ),
            16 =>
            array (
                'id' => 'f85e4e444fc954430170c41779a4238f84cd6fed905f682795cd4d7b6a291ec5204a10ac0480eb30',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-07-30 11:38:49',
                'updated_at' => '2019-07-30 11:38:49',
                'expires_at' => '2020-07-30 12:38:49',
            ),
            17 =>
            array (
                'id' => 'f8bf983a42c543b99128296e4bc7c2d17a52b5b9ef69670c629b93a653c6a4af27be452e0c331f79',
                'user_id' => 1,
                'client_id' => 1,
                'name' => 'Personal Access Token',
                'scopes' => '[]',
                'revoked' => 1,
                'created_at' => '2019-08-04 12:28:55',
                'updated_at' => '2019-08-04 12:28:55',
                'expires_at' => '2020-08-04 13:28:55',
            ),
        ));


    }
}
