<?php

use Database\seeds\CustomLandingAboutTableSeeder;
use Database\seeds\CustomLandingAboutTempTableSeeder;
use Database\seeds\CustomLandingAdvantageTableSeeder;
use Database\seeds\CustomLandingAdvantageTempTableSeeder;
use Database\seeds\CustomLandingBannerTableSeeder;
use Database\seeds\CustomLandingBannerTempTableSeeder;
use Database\seeds\CustomLandingCoinsTableSeeder;
use Database\seeds\CustomLandingCoinsTempTableSeeder;
use Database\seeds\CustomLandingFaqsTableSeeder;
use Database\seeds\CustomLandingFaqsTempTableSeeder;
use Database\seeds\CustomLandingFeatureTableSeeder;
use Database\seeds\CustomLandingFeatureTempTableSeeder;
use Database\seeds\CustomLandingP2pTableSeeder;
use Database\seeds\CustomLandingP2pTempTableSeeder;
use Database\seeds\CustomLandingProcessTableSeeder;
use Database\seeds\CustomLandingProcessTempTableSeeder;
use Database\seeds\CustomLandingTeamsTableSeeder;
use Database\seeds\CustomLandingTeamsTempTableSeeder;
use Database\seeds\CustomLandingTestimonialTableSeeder;
use Database\seeds\CustomLandingTradeTableSeeder;
use Database\seeds\CustomLandingTradeTempTableSeeder;
use Database\seeds\CustomPageSeeder;
use Database\seeds\CustomSectionSeeder;
use Database\seeds\CustomSectionTempSeeder;
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
        $this->call(CountrySeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AdminSettingTableSeeder::class);
        $this->call(CoinSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(CustomPageSeeder::class);
        $this->call(CustomSectionSeeder::class);
        $this->call(CustomSectionTempSeeder::class);
        $this->call(CustomLandingAboutTableSeeder::class);
        $this->call(CustomLandingAdvantageTableSeeder::class);
        $this->call(CustomLandingBannerTableSeeder::class);
        $this->call(CustomLandingCoinsTableSeeder::class);
        $this->call(CustomLandingFaqsTableSeeder::class);
        $this->call(CustomLandingFeatureTableSeeder::class);
        $this->call(CustomLandingP2pTableSeeder::class);
        $this->call(CustomLandingProcessTableSeeder::class);
        $this->call(CustomLandingTeamsTableSeeder::class);
        $this->call(CustomLandingTestimonialTableSeeder::class);
        $this->call(CustomLandingTestimonialTempTableSeeder::class);
        $this->call(CustomLandingTradeTableSeeder::class);
        $this->call(CustomLandingAboutTempTableSeeder::class);
        $this->call(CustomLandingAdvantageTempTableSeeder::class);
        $this->call(CustomLandingBannerTempTableSeeder::class);
        $this->call(CustomLandingCoinsTempTableSeeder::class);
        $this->call(CustomLandingFaqsTempTableSeeder::class);
        $this->call(CustomLandingFeatureTempTableSeeder::class);
        $this->call(CustomLandingP2pTempTableSeeder::class);
        $this->call(CustomLandingProcessTempTableSeeder::class);
        $this->call(CustomLandingTeamsTempTableSeeder::class);
        $this->call(CustomLandingTradeTempTableSeeder::class);
    }
}
