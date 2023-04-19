<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingFeatureTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_feature')->get()->toArray()) {
            DB::table('custom_landing_feature')->insert(array (
                0 =>
                    array (
                        'id' => 243,
                        'landing_page_id' => 3,
                        'serial' => 1,
                        'icon' => NULL,
                        'sub_title' => 'Various Ways To Pay',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit ame dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 244,
                        'landing_page_id' => 3,
                        'serial' => 2,
                        'icon' => NULL,
                        'sub_title' => 'No Middleman',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit ame dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 245,
                        'landing_page_id' => 3,
                        'serial' => 3,
                        'icon' => NULL,
                        'sub_title' => 'Worldwide Service',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit ame dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 246,
                        'landing_page_id' => 3,
                        'serial' => 4,
                        'icon' => NULL,
                        'sub_title' => 'Encrypted Message',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit ame dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 247,
                        'landing_page_id' => 3,
                        'serial' => 5,
                        'icon' => NULL,
                        'sub_title' => 'Fast Service',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit ame dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 248,
                        'landing_page_id' => 3,
                        'serial' => 6,
                        'icon' => NULL,
                        'sub_title' => 'Non-custodial',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit ame dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                6 =>
                    array (
                        'id' => 249,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'icon' => 'landing/feature/kfYGQKNrCrvS5NfIv7WMkBHu2anPPNRaFNDTFcKs.png',
                        'sub_title' => 'Powerful Matching Engine',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                7 =>
                    array (
                        'id' => 250,
                        'landing_page_id' => 2,
                        'serial' => 2,
                        'icon' => 'landing/feature/0MmsLGfdEUT7FI1xJaRRPpQhPuTFzg52ux7Txlp5.png',
                        'sub_title' => 'Multi-Layer Security',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                8 =>
                    array (
                        'id' => 251,
                        'landing_page_id' => 2,
                        'serial' => 3,
                        'icon' => 'landing/feature/eDacbrXaxeiJp2ERnau1x1CPbxRNDPTFBopLiPUB.png',
                        'sub_title' => 'Instant KYC And AML Verifications',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                9 =>
                    array (
                        'id' => 252,
                        'landing_page_id' => 2,
                        'serial' => 4,
                        'icon' => 'landing/feature/8452eymLxAbhnD0aGaPZoWFWsBpbiA5YvOiiCAFa.png',
                        'sub_title' => 'Escrow System',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                10 =>
                    array (
                        'id' => 253,
                        'landing_page_id' => 2,
                        'serial' => 5,
                        'icon' => 'landing/feature/BbWzXc8rUbHd2YCiyHMX2bHr1gZdL0xXBXzr2Eji.png',
                        'sub_title' => 'Atomic Swap',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                11 =>
                    array (
                        'id' => 254,
                        'landing_page_id' => 2,
                        'serial' => 6,
                        'icon' => 'landing/feature/WmwEeRQXtx3Ju2h0DCktmErH9xOs0J1rfaCd8kH4.png',
                        'sub_title' => 'Dispute Management',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                12 =>
                    array (
                        'id' => 255,
                        'landing_page_id' => 2,
                        'serial' => 7,
                        'icon' => 'landing/feature/uhrYG2VzlMhFwokSqkKEha4t2eC0TsMcgCgTTcD1.png',
                        'sub_title' => 'Preferred Trader Selection',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                13 =>
                    array (
                        'id' => 256,
                        'landing_page_id' => 2,
                        'serial' => 8,
                        'icon' => 'landing/feature/EkTfZYNw0UQOWNu7Dz951H9hIhpkL5R78SmQ82mR.png',
                        'sub_title' => 'Admin Panel',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                14 =>
                    array (
                        'id' => 257,
                        'landing_page_id' => 2,
                        'serial' => 9,
                        'icon' => 'landing/feature/bkZ01KWBrEdWQO4AWtZQlvtyJOtu4bUqk7gj2EfU.png',
                        'sub_title' => 'DMulti-Language Support',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam doloremque autem ex porro adipisci ab a at!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                15 =>
                    array (
                        'id' => 258,
                        'landing_page_id' => 1,
                        'serial' => 1,
                        'icon' => 'landing/feature/lKqxYTJXYLtDW7bEpj2OPpVlnyuCrRfOSq6B69VN.svg',
                        'sub_title' => 'Buy Bitcoin Online',
                        'sub_description' => 'The best way to buy Bitcoin and other cryptocurrencies are the methods that are flexible enough to fit your needs.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                16 =>
                    array (
                        'id' => 259,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'icon' => 'landing/feature/JJCcoQVRhvL7yWeJsuT9ZB9X5xuDXSNgQMlNTjBc.svg',
                        'sub_title' => 'Buy Bitcoin Online',
                        'sub_description' => 'The best way to buy Bitcoin and other cryptocurrencies are the methods that are flexible enough to fit your needs.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                17 =>
                    array (
                        'id' => 260,
                        'landing_page_id' => 1,
                        'serial' => 3,
                        'icon' => 'landing/feature/W9SC9cAholiSb12PfAh39bgdXdWAfSBgVohe7DZV.svg',
                        'sub_title' => 'Buy Bitcoin Online',
                        'sub_description' => 'The best way to buy Bitcoin and other cryptocurrencies are the methods that are flexible enough to fit your needs.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                18 =>
                    array (
                        'id' => 261,
                        'landing_page_id' => 1,
                        'serial' => 4,
                        'icon' => 'landing/feature/fXDPgvSXwCQN3NeCQMCzTbMwhB4KgVYSwAXQM8NL.svg',
                        'sub_title' => 'Buy Bitcoin Online',
                        'sub_description' => 'The best way to buy Bitcoin and other cryptocurrencies are the methods that are flexible enough to fit your needs.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                19 =>
                    array (
                        'id' => 262,
                        'landing_page_id' => 1,
                        'serial' => 5,
                        'icon' => 'landing/feature/RMDEP4tdgLbuqqhCF11tBo2v2XZefSlngxS3pS3J.svg',
                        'sub_title' => 'Buy Bitcoin Online',
                        'sub_description' => 'The best way to buy Bitcoin and other cryptocurrencies are the methods that are flexible enough to fit your needs.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                20 =>
                    array (
                        'id' => 263,
                        'landing_page_id' => 1,
                        'serial' => 6,
                        'icon' => 'landing/feature/UKJYxtKuDcbEf9PTdzbY4nJouEUfh1aDSi8oqueM.svg',
                        'sub_title' => 'Buy Bitcoin Online',
                        'sub_description' => 'The best way to buy Bitcoin and other cryptocurrencies are the methods that are flexible enough to fit your needs.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
