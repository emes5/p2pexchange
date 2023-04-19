<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingBannerTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_banner')->get()->toArray()) {
            DB::table('custom_landing_banner')->insert(array (
                0 =>
                    array (
                        'id' => 65,
                        'landing_page_id' => 3,
                        'image' => 'landing/banner/yXZGLPYYIiQI3bHMMiuZFTxgyiihKYvCu4duqx1i.png',
                        'video_link' => NULL,
                        'title' => 'Most Popular Peer To Peer Crypto Trading Marketplace.',
                        'short_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which slightly believable.',
                        'long_description' => NULL,
                        'login_button_name' => 'Login',
                        'register_button_name' => 'Registration',
                        'is_filter' => 0,
                        'created_at' => '2021-12-10 13:05:03',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 66,
                        'landing_page_id' => 2,
                        'image' => 'landing/banner/ZCNmI7MOK6aswS2xlJBE03QRW53uyxvvwCJkYzkD.jpg',
                        'video_link' => NULL,
                        'title' => 'Most Popular Peer To Peer Crypto Trading Marketplace.',
                        'short_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which slightly believable.',
                        'long_description' => NULL,
                        'login_button_name' => 'Login',
                        'register_button_name' => 'Registration',
                        'is_filter' => 1,
                        'created_at' => '2021-12-10 13:05:03',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 67,
                        'landing_page_id' => 1,
                        'image' => 'landing/banner/61xqFrCuFr1d5J4XPQHAXdMB79LngWegLjScfBKU.jpg',
                        'video_link' => NULL,
                        'title' => 'Most Popular Peer To Peer Crypto Trading Marketplace.',
                        'short_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which slightly believable.',
                        'long_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident iusto enim autem a veniam laborum.',
                        'login_button_name' => 'Login',
                        'register_button_name' => 'Registration',
                        'is_filter' => 1,
                        'created_at' => '2021-12-10 13:05:03',
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
