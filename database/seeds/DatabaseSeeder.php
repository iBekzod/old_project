<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(BusinessSettingsTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(AppSettingsTableSeeder::class);
        $this->call(AttributesTableSeeder::class);
        $this->call(AttributeTranslationsTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(GeneralSettingsTableSeeder::class);
        $this->call(HomeCategoriesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(OauthAccessTokensTableSeeder::class);
        $this->call(OauthAuthCodesTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(OauthPersonalAccessClientsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PoliciesTableSeeder::class);
        $this->call(SellersTableSeeder::class);
        $this->call(SeoSettingsTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(TranslationsTableSeeder::class);
        $this->call(AddonsTableSeeder::class);
    }
}
