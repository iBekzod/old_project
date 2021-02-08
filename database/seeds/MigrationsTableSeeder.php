<?php



use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('migrations')->delete();

        \DB::table('migrations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ),
            2 =>
            array (
                'id' => 3,
                'migration' => '2021_01_25_082720_create_addons_table',
                'batch' => 0,
            ),
            3 =>
            array (
                'id' => 4,
                'migration' => '2021_01_25_082720_create_addresses_table',
                'batch' => 0,
            ),
            4 =>
            array (
                'id' => 5,
                'migration' => '2021_01_25_082720_create_app_settings_table',
                'batch' => 0,
            ),
            5 =>
            array (
                'id' => 6,
                'migration' => '2021_01_25_082720_create_attribute_translations_table',
                'batch' => 0,
            ),
            6 =>
            array (
                'id' => 7,
                'migration' => '2021_01_25_082720_create_attributes_table',
                'batch' => 0,
            ),
            7 =>
            array (
                'id' => 8,
                'migration' => '2021_01_25_082720_create_banners_table',
                'batch' => 0,
            ),
            8 =>
            array (
                'id' => 9,
                'migration' => '2021_01_25_082720_create_brand_translations_table',
                'batch' => 0,
            ),
            9 =>
            array (
                'id' => 10,
                'migration' => '2021_01_25_082720_create_brands_table',
                'batch' => 0,
            ),
            10 =>
            array (
                'id' => 11,
                'migration' => '2021_01_25_082720_create_business_settings_table',
                'batch' => 0,
            ),
            11 =>
            array (
                'id' => 12,
                'migration' => '2021_01_25_082720_create_carts_table',
                'batch' => 0,
            ),
            12 =>
            array (
                'id' => 13,
                'migration' => '2021_01_25_082720_create_categories_table',
                'batch' => 0,
            ),
            13 =>
            array (
                'id' => 14,
                'migration' => '2021_01_25_082720_create_category_translations_table',
                'batch' => 0,
            ),
            14 =>
            array (
                'id' => 15,
                'migration' => '2021_01_25_082720_create_cities_table',
                'batch' => 0,
            ),
            15 =>
            array (
                'id' => 16,
                'migration' => '2021_01_25_082720_create_city_translations_table',
                'batch' => 0,
            ),
            16 =>
            array (
                'id' => 17,
                'migration' => '2021_01_25_082720_create_colors_table',
                'batch' => 0,
            ),
            17 =>
            array (
                'id' => 18,
                'migration' => '2021_01_25_082720_create_conversations_table',
                'batch' => 0,
            ),
            18 =>
            array (
                'id' => 19,
                'migration' => '2021_01_25_082720_create_countries_table',
                'batch' => 0,
            ),
            19 =>
            array (
                'id' => 20,
                'migration' => '2021_01_25_082720_create_coupon_usages_table',
                'batch' => 0,
            ),
            20 =>
            array (
                'id' => 21,
                'migration' => '2021_01_25_082720_create_coupons_table',
                'batch' => 0,
            ),
            21 =>
            array (
                'id' => 22,
                'migration' => '2021_01_25_082720_create_currencies_table',
                'batch' => 0,
            ),
            22 =>
            array (
                'id' => 23,
                'migration' => '2021_01_25_082720_create_customer_package_payments_table',
                'batch' => 0,
            ),
            23 =>
            array (
                'id' => 24,
                'migration' => '2021_01_25_082720_create_customer_package_translations_table',
                'batch' => 0,
            ),
            24 =>
            array (
                'id' => 25,
                'migration' => '2021_01_25_082720_create_customer_packages_table',
                'batch' => 0,
            ),
            25 =>
            array (
                'id' => 26,
                'migration' => '2021_01_25_082720_create_customer_product_translations_table',
                'batch' => 0,
            ),
            26 =>
            array (
                'id' => 27,
                'migration' => '2021_01_25_082720_create_customer_products_table',
                'batch' => 0,
            ),
            27 =>
            array (
                'id' => 28,
                'migration' => '2021_01_25_082720_create_customers_table',
                'batch' => 0,
            ),
            28 =>
            array (
                'id' => 29,
                'migration' => '2021_01_25_082720_create_flash_deal_products_table',
                'batch' => 0,
            ),
            29 =>
            array (
                'id' => 30,
                'migration' => '2021_01_25_082720_create_flash_deal_translations_table',
                'batch' => 0,
            ),
            30 =>
            array (
                'id' => 31,
                'migration' => '2021_01_25_082720_create_flash_deals_table',
                'batch' => 0,
            ),
            31 =>
            array (
                'id' => 32,
                'migration' => '2021_01_25_082720_create_general_settings_table',
                'batch' => 0,
            ),
            32 =>
            array (
                'id' => 33,
                'migration' => '2021_01_25_082720_create_home_categories_table',
                'batch' => 0,
            ),
            33 =>
            array (
                'id' => 34,
                'migration' => '2021_01_25_082720_create_languages_table',
                'batch' => 0,
            ),
            34 =>
            array (
                'id' => 35,
                'migration' => '2021_01_25_082720_create_links_table',
                'batch' => 0,
            ),
            35 =>
            array (
                'id' => 36,
                'migration' => '2021_01_25_082720_create_messages_table',
                'batch' => 0,
            ),
            36 =>
            array (
                'id' => 37,
                'migration' => '2021_01_25_082720_create_oauth_access_tokens_table',
                'batch' => 0,
            ),
            37 =>
            array (
                'id' => 38,
                'migration' => '2021_01_25_082720_create_oauth_auth_codes_table',
                'batch' => 0,
            ),
            38 =>
            array (
                'id' => 39,
                'migration' => '2021_01_25_082720_create_oauth_clients_table',
                'batch' => 0,
            ),
            39 =>
            array (
                'id' => 40,
                'migration' => '2021_01_25_082720_create_oauth_personal_access_clients_table',
                'batch' => 0,
            ),
            40 =>
            array (
                'id' => 41,
                'migration' => '2021_01_25_082720_create_oauth_refresh_tokens_table',
                'batch' => 0,
            ),
            41 =>
            array (
                'id' => 42,
                'migration' => '2021_01_25_082720_create_order_details_table',
                'batch' => 0,
            ),
            42 =>
            array (
                'id' => 43,
                'migration' => '2021_01_25_082720_create_orders_table',
                'batch' => 0,
            ),
            43 =>
            array (
                'id' => 44,
                'migration' => '2021_01_25_082720_create_page_translations_table',
                'batch' => 0,
            ),
            44 =>
            array (
                'id' => 45,
                'migration' => '2021_01_25_082720_create_pages_table',
                'batch' => 0,
            ),
            45 =>
            array (
                'id' => 46,
                'migration' => '2021_01_25_082720_create_password_resets_table',
                'batch' => 0,
            ),
            46 =>
            array (
                'id' => 47,
                'migration' => '2021_01_25_082720_create_payments_table',
                'batch' => 0,
            ),
            47 =>
            array (
                'id' => 48,
                'migration' => '2021_01_25_082720_create_pickup_point_translations_table',
                'batch' => 0,
            ),
            48 =>
            array (
                'id' => 49,
                'migration' => '2021_01_25_082720_create_pickup_points_table',
                'batch' => 0,
            ),
            49 =>
            array (
                'id' => 50,
                'migration' => '2021_01_25_082720_create_policies_table',
                'batch' => 0,
            ),
            50 =>
            array (
                'id' => 51,
                'migration' => '2021_01_25_082720_create_product_stocks_table',
                'batch' => 0,
            ),
            51 =>
            array (
                'id' => 52,
                'migration' => '2021_01_25_082720_create_product_translations_table',
                'batch' => 0,
            ),
            52 =>
            array (
                'id' => 53,
                'migration' => '2021_01_25_082720_create_products_table',
                'batch' => 0,
            ),
            53 =>
            array (
                'id' => 54,
                'migration' => '2021_01_25_082720_create_reviews_table',
                'batch' => 0,
            ),
            54 =>
            array (
                'id' => 55,
                'migration' => '2021_01_25_082720_create_role_translations_table',
                'batch' => 0,
            ),
            55 =>
            array (
                'id' => 56,
                'migration' => '2021_01_25_082720_create_roles_table',
                'batch' => 0,
            ),
            56 =>
            array (
                'id' => 57,
                'migration' => '2021_01_25_082720_create_searches_table',
                'batch' => 0,
            ),
            57 =>
            array (
                'id' => 58,
                'migration' => '2021_01_25_082720_create_seller_withdraw_requests_table',
                'batch' => 0,
            ),
            58 =>
            array (
                'id' => 59,
                'migration' => '2021_01_25_082720_create_sellers_table',
                'batch' => 0,
            ),
            59 =>
            array (
                'id' => 60,
                'migration' => '2021_01_25_082720_create_seo_settings_table',
                'batch' => 0,
            ),
            60 =>
            array (
                'id' => 61,
                'migration' => '2021_01_25_082720_create_shops_table',
                'batch' => 0,
            ),
            61 =>
            array (
                'id' => 62,
                'migration' => '2021_01_25_082720_create_sliders_table',
                'batch' => 0,
            ),
            62 =>
            array (
                'id' => 63,
                'migration' => '2021_01_25_082720_create_staff_table',
                'batch' => 0,
            ),
            63 =>
            array (
                'id' => 64,
                'migration' => '2021_01_25_082720_create_subscribers_table',
                'batch' => 0,
            ),
            64 =>
            array (
                'id' => 65,
                'migration' => '2021_01_25_082720_create_ticket_replies_table',
                'batch' => 0,
            ),
            65 =>
            array (
                'id' => 66,
                'migration' => '2021_01_25_082720_create_tickets_table',
                'batch' => 0,
            ),
            66 =>
            array (
                'id' => 67,
                'migration' => '2021_01_25_082720_create_translations_table',
                'batch' => 0,
            ),
            67 =>
            array (
                'id' => 68,
                'migration' => '2021_01_25_082720_create_uploads_table',
                'batch' => 0,
            ),
            68 =>
            array (
                'id' => 69,
                'migration' => '2021_01_25_082720_create_users_table',
                'batch' => 0,
            ),
            69 =>
            array (
                'id' => 70,
                'migration' => '2021_01_25_082720_create_wallets_table',
                'batch' => 0,
            ),
            70 =>
            array (
                'id' => 71,
                'migration' => '2021_01_25_082720_create_wishlists_table',
                'batch' => 0,
            ),
        ));


    }
}
