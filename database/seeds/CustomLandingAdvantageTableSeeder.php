<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingAdvantageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_advantage')->get()->toArray()) {
            DB::table('custom_landing_advantage')->insert(array (
                0 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'image' => NULL,
                        'sub_title' => 'dfsfs sfs',
                        'sub_description' => 'sdfs fsd fsfs sf',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 1,
                        'serial' => 3,
                        'image' => NULL,
                        'sub_title' => 'dfsfs sfs',
                        'sub_description' => 'sdfs fsd fsfs sf',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 125,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'image' => 'landing/advantage/JBMsjhsJ4T41pBm3tyDEi1qRLMGam4jPMbq2tQ1s.png',
                        'sub_title' => 'Purchase Easily',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum labore natus quidem. dfsd',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 126,
                        'landing_page_id' => 2,
                        'serial' => 2,
                        'image' => 'landing/advantage/fy89ZAUzGOzHUfApAyA8hG9ckU2LRi51zstYh5NE.png',
                        'sub_title' => 'Instant',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum labore natus quidem.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 127,
                        'landing_page_id' => 2,
                        'serial' => 3,
                        'image' => 'landing/advantage/uA8H5lXakhrL32dLjuD8uFvYF4rQavgGk5g77tuD.png',
                        'sub_title' => 'Safe & Secure',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum labore natus quidem.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 128,
                        'landing_page_id' => 2,
                        'serial' => 4,
                        'image' => 'landing/advantage/f83z7ePHzc016jewvliamvVCaX6rMfyEBWz5qM0c.png',
                        'sub_title' => 'Convenient',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum labore natus quidem.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
