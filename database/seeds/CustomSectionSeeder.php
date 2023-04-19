<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_sections')->get()->toArray()) {
            DB::table('custom_landing_sections')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'landing_page_id' => 1,
                        'section_name' => 'Banner',
                        'section_key' => 'banner',
                        'related_table' => 'custom_landing_banner',
                        'section_title' => 'Most Popular Peer To Peer Crypto Trading Marketplace.',
                        'section_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which slightly believable.',
                        'status' => 1,
                        'created_at' => '2021-12-10 12:28:45',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 1,
                        'section_name' => 'About',
                        'section_key' => 'about',
                        'related_table' => 'custom_landing_about',
                        'section_title' => 'Secure Trading Made Easy',
                        'section_description' => 'It shouldn\'t be challenging to stay safe trading cryptocurrency.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:08:06',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 1,
                        'section_name' => 'Feature',
                        'section_key' => 'feature',
                        'related_table' => 'custom_landing_feature',
                        'section_title' => 'Pexeer For Your Trading',
                        'section_description' => 'It shouldn\'t be challenging to stay safe trading cryptocurrency.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:08:06',
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 4,
                        'landing_page_id' => 1,
                        'section_name' => 'Coin Buy or Sell',
                        'section_key' => 'coin_buy_sell',
                        'related_table' => 'custom_landing_coins',
                        'section_title' => 'P2P Crypto Exchange',
                        'section_description' => 'Elevate your financial freedom to a higher plane with Pexeer.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:08:06',
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 5,
                        'landing_page_id' => 1,
                        'section_name' => 'Process',
                        'section_key' => 'process',
                        'related_table' => 'custom_landing_process',
                        'section_title' => 'How To Do Pexeer Trading',
                        'section_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit amet dignissim.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:21:30',
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 6,
                        'landing_page_id' => 1,
                        'section_name' => 'Testimonial',
                        'section_key' => 'testimonial',
                        'related_table' => 'custom_landing_testimonial',
                        'section_title' => 'Testimonials',
                        'section_description' => 'Elevate your financial freedom to a higher plane with Paxful.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:21:30',
                        'updated_at' => NULL,
                    ),
                6 =>
                    array (
                        'id' => 7,
                        'landing_page_id' => 1,
                        'section_name' => 'Team',
                        'section_key' => 'team',
                        'related_table' => 'custom_landing_teams',
                        'section_title' => 'The Team',
                        'section_description' => 'Elevate your financial freedom to a higher plane with Pexeer.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:21:30',
                        'updated_at' => NULL,
                    ),
                7 =>
                    array (
                        'id' => 8,
                        'landing_page_id' => 1,
                        'section_name' => 'Faq',
                        'section_key' => 'faq',
                        'related_table' => 'custom_landing_faqs',
                        'section_title' => 'What Want Our Customer',
                        'section_description' => 'Elevate your financial freedom to a higher plane with Pexeer.',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:21:30',
                        'updated_at' => NULL,
                    ),
                8 =>
                    array (
                        'id' => 9,
                        'landing_page_id' => 1,
                        'section_name' => 'Subscribe',
                        'section_key' => 'subscribe',
                        'related_table' => NULL,
                        'section_title' => 'Subscribe To Stay',
                        'section_description' => 'join newsletter & learn about blockchain & bitcoin',
                        'status' => 1,
                        'created_at' => '2021-12-10 13:32:53',
                        'updated_at' => NULL,
                    ),
                9 =>
                    array (
                        'id' => 10,
                        'landing_page_id' => 2,
                        'section_name' => 'Banner',
                        'section_key' => 'banner',
                        'related_table' => 'custom_landing_banner',
                        'section_title' => 'Most Popular Peer To Peer Crypto Trading Marketplace.',
                        'section_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which slightly believable.',
                        'status' => 1,
                        'created_at' => '2021-12-19 23:18:17',
                        'updated_at' => NULL,
                    ),
                10 =>
                    array (
                        'id' => 11,
                        'landing_page_id' => 2,
                        'section_name' => 'Trade Anywhere',
                        'section_key' => 'trade_anywhere',
                        'related_table' => 'custom_landing_trade',
                        'section_title' => 'Trade Anywhere',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                11 =>
                    array (
                        'id' => 12,
                        'landing_page_id' => 2,
                        'section_name' => 'Market Trend',
                        'section_key' => 'market_trend',
                        'related_table' => NULL,
                        'section_title' => 'Market Trend',
                        'section_description' => '
Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                12 =>
                    array (
                        'id' => 13,
                        'landing_page_id' => 2,
                        'section_name' => 'Cash Crypto Today',
                        'section_key' => 'advantage',
                        'related_table' => 'custom_landing_advantage',
                        'section_title' => 'Cash-In On Crypto Today',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                13 =>
                    array (
                        'id' => 14,
                        'landing_page_id' => 2,
                        'section_name' => 'Feature',
                        'section_key' => 'feature',
                        'related_table' => 'custom_landing_feature',
                        'section_title' => 'P2p Cryptocurrency Exchnage Features',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => '2021-12-19 23:18:17',
                        'updated_at' => NULL,
                    ),
                14 =>
                    array (
                        'id' => 15,
                        'landing_page_id' => 2,
                        'section_name' => 'How P2p Work',
                        'section_key' => 'how_to_work',
                        'related_table' => 'custom_landing_p2p',
                        'section_title' => 'How P2p Work',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                15 =>
                    array (
                        'id' => 16,
                        'landing_page_id' => 2,
                        'section_name' => 'Process',
                        'section_key' => 'process',
                        'related_table' => 'custom_landing_process',
                        'section_title' => 'How To Do Pexeer Trading',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => '2021-12-19 23:18:17',
                        'updated_at' => NULL,
                    ),
                16 =>
                    array (
                        'id' => 17,
                        'landing_page_id' => 2,
                        'section_name' => 'Teams',
                        'section_key' => 'team',
                        'related_table' => 'custom_landing_teams',
                        'section_title' => 'Out Team',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => '2021-12-19 23:18:17',
                        'updated_at' => NULL,
                    ),
                17 =>
                    array (
                        'id' => 18,
                        'landing_page_id' => 2,
                        'section_name' => 'Testimonial',
                        'section_key' => 'testimonial',
                        'related_table' => 'custom_landing_testimonial',
                        'section_title' => 'Testimonial',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => '2021-12-19 23:18:17',
                        'updated_at' => NULL,
                    ),
                18 =>
                    array (
                        'id' => 19,
                        'landing_page_id' => 2,
                        'section_name' => 'Faqs',
                        'section_key' => 'faq',
                        'related_table' => 'custom_landing_faqs',
                        'section_title' => 'Faq',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => '2021-12-19 23:18:17',
                        'updated_at' => NULL,
                    ),
                19 =>
                    array (
                        'id' => 20,
                        'landing_page_id' => 3,
                        'section_name' => 'Banner',
                        'section_key' => 'banner',
                        'related_table' => 'custom_landing_banner_temp',
                        'section_title' => 'Most Popular Peer To Peer Crypto Trading Marketplace.',
                        'section_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which slightly believable.',
                        'status' => 1,
                        'created_at' => '2021-12-21 15:52:44',
                        'updated_at' => NULL,
                    ),
                20 =>
                    array (
                        'id' => 21,
                        'landing_page_id' => 3,
                        'section_name' => 'About',
                        'section_key' => 'about',
                        'related_table' => 'custom_landing_about_temp',
                        'section_title' => 'Why You Will Choose Pexeer For Your Trading?',
                        'section_description' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                21 =>
                    array (
                        'id' => 22,
                        'landing_page_id' => 3,
                        'section_name' => 'Feature',
                        'section_key' => 'feature',
                        'related_table' => 'custom_landing_feature_temp',
                        'section_title' => 'Know About Pexeer’s Feature',
                        'section_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit amet dignissim.',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                22 =>
                    array (
                        'id' => 23,
                        'landing_page_id' => 3,
                        'section_name' => 'Coin Buy or Sell',
                        'section_key' => 'coin_buy_sell',
                        'related_table' => 'custom_landing_coins_temp',
                        'section_title' => '',
                        'section_description' => '',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                23 =>
                    array (
                        'id' => 24,
                        'landing_page_id' => 3,
                        'section_name' => 'Process',
                        'section_key' => 'process',
                        'related_table' => 'custom_landing_process',
                        'section_title' => 'How To Do Pexeer Trading',
                        'section_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit amet dignissim.',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                24 =>
                    array (
                        'id' => 25,
                        'landing_page_id' => 3,
                        'section_name' => 'testimonial',
                        'section_key' => 'testimonial',
                        'related_table' => 'custom_landing_testimonial_temp',
                        'section_title' => 'What Says Our Customer',
                        'section_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit amet dignissim.',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                25 =>
                    array (
                        'id' => 26,
                        'landing_page_id' => 3,
                        'section_name' => 'faq',
                        'section_key' => 'faq',
                        'related_table' => 'custom_landing_faqs_temp',
                        'section_title' => 'Faq',
                        'section_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                26 =>
                    array (
                        'id' => 27,
                        'landing_page_id' => 3,
                        'section_name' => 'subscribe',
                        'section_key' => 'subscribe',
                        'related_table' => NULL,
                        'section_title' => 'Join Our Newsletter',
                        'section_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit amet dignissim.',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
