<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_page')->get()->toArray()) {
            DB::table('custom_landing_page')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'page_title' => 'Custom Landing 1',
                        'page_key' => 'custom_one',
                        'resource_path' => 'landing.custom_one',
                        'main_primary_color' => '#FFA400',
                        'main_hover_color' => '#D88D07',
                        'temp_primary_color' => '#FFA400',
                        'temp_hover_color' => '#D88D07',
                        'status' => 0,
                        'created_at' => '2021-12-21 15:52:44',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'page_title' => 'Custom Landing 2',
                        'page_key' => 'custom_two',
                        'resource_path' => 'landing.custom_two',
                        'main_primary_color' => '#0EC6D5',
                        'main_hover_color' => '#14D2E1',
                        'temp_primary_color' => '#0EC6D5',
                        'temp_hover_color' => '#14D2E1',
                        'status' => 0,
                        'created_at' => '2021-12-21 15:52:45',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'page_title' => 'Custom Landing 3',
                        'page_key' => 'custom_three',
                        'resource_path' => 'landing.custom_three',
                        'main_primary_color' => '#FC541F',
                        'main_hover_color' => '#FE8F28',
                        'temp_primary_color' => '#FC541F',
                        'temp_hover_color' => '#FE8F28',
                        'status' => 1,
                        'created_at' => '2021-12-21 15:52:45',
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
