<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingAboutTempTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_about_temp')->get()->toArray()) {
            DB::table('custom_landing_about_temp')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'landing_page_id' => 1,
                        'image' => 'landing/about/sMjaym6cRT4LtQxsmYLS0MqstGN50pf37LYdKf4u.png',
                        'video_link' => NULL,
                        'title' => 'Secure Trading Made Easy',
                        'short_description' => 'It shouldn\'t be challenging to stay safe trading cryptocurrency.',
                        'long_description' => 'Easy to follow trading processes that enable you to trade safely with escrow protection so you can convert Bitcoin to cash or trade cryptocurrency with hundreds of other payment methods.',
                        'button_name' => 'Know More',
                        'button_link' => 'http://localhost:8000/admin/landing-page-settings',
                        'created_at' => '2021-12-10 13:06:59',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 2,
                        'image' => 'landing/about/ZUk0jJ3Vz8trw24YCtAhYLM2MelLkU22Wd9gyy2n.jpg',
                        'video_link' => NULL,
                        'title' => 'Secure Trading Made Easy',
                        'short_description' => 'It shouldn\'t be challenging to stay safe trading cryptocurrency.',
                        'long_description' => 'Easy to follow trading processes that enable you to trade safely with escrow protection so you can convert Bitcoin to cash or trade cryptocurrency with hundreds of other payment methods.',
                        'button_name' => 'Know More',
                        'button_link' => 'http://localhost:8000/admin/landing-page-settings',
                        'created_at' => '2021-12-10 13:06:59',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 3,
                        'image' => 'landing/about/KsOMp2TV17Cet1wcIbymNVLsQ3Lw9V2p9kdiiKtX.png',
                        'video_link' => NULL,
                        'title' => 'Why You Will Choose Pexeer For Your Trading?',
                        'short_description' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
                        'long_description' => 'Cenenatis. Suspendisse est nulla, sollicitudin eget viverra quis, mo quis tortor. Fusce ac lacus ut nisl hendrerit mximus. Intege scsque molestie molestie. Suspendse eleifend urna at euismod ornare. Mauris dolosem, scelerisque eleifend dolor nec, ornare laoreet velit.',
                        'button_name' => 'Know More',
                        'button_link' => 'http://localhost:8000/admin/landing-page-settings',
                        'created_at' => '2021-12-10 13:06:59',
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
