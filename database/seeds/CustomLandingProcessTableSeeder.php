<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingProcessTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_process')->get()->toArray()) {
            DB::table('custom_landing_process')->insert(array (
                0 =>
                    array (
                        'id' => 244,
                        'landing_page_id' => 3,
                        'serial' => 1,
                        'image' => 'landing/process/WxQ1j8sz5uIjeL7W5k5PfitZ2b49hPYWokVH7ifA.png',
                        'sub_title' => 'Create account',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 245,
                        'landing_page_id' => 3,
                        'serial' => 2,
                        'image' => 'landing/process/LoOhgU2iAqlAWGvrfM4nkpvUpl1kqnFvYG2tHZbK.png',
                        'sub_title' => 'Watch Buy And Selling',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. ds',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 246,
                        'landing_page_id' => 3,
                        'serial' => 3,
                        'image' => 'landing/process/msfjgRetwjqb5qNM9PCavtUWwHNkIAwPzTn17g9W.png',
                        'sub_title' => 'Open Trade',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. ds',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 247,
                        'landing_page_id' => 3,
                        'serial' => 4,
                        'image' => 'landing/process/s05zYRHdI3UUarYl2k3loqRodnSX0e3DGaSGGBb4.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. ds',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 248,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'image' => 'landing/process/WPx8rEf4ywBMdWm5VG4YMH6FbJ4ep9LKiTL6YXhl.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Make Exchange Make Exchange Make Exchange',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 249,
                        'landing_page_id' => 2,
                        'serial' => 2,
                        'image' => 'landing/process/nWE3pZEQSAAxqvYID0mYBp57Lxjvnhm2KlDLxLjK.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Make Exchange Make Exchange Make Exchange',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                6 =>
                    array (
                        'id' => 250,
                        'landing_page_id' => 2,
                        'serial' => 3,
                        'image' => 'landing/process/WwH1flDpPS9JdN5Eqa3GEaDEQldkd6uKiplgLPyI.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Make Exchange Make Exchange Make Exchange',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                7 =>
                    array (
                        'id' => 251,
                        'landing_page_id' => 1,
                        'serial' => 1,
                        'image' => 'landing/process/AO9l5vbBgQ7URF6mX9s5Dc4m3kUbR7d3ITeNkbwL.png',
                        'sub_title' => 'Create Account',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                8 =>
                    array (
                        'id' => 252,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'image' => 'landing/process/GnMqHtS3nF6ew2EkvjFtjt3goCNUDpfPyHp9BQv1.png',
                        'sub_title' => 'Watch Buy And Selling',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                9 =>
                    array (
                        'id' => 253,
                        'landing_page_id' => 1,
                        'serial' => 3,
                        'image' => 'landing/process/LEt27873HkEDBO31YiFWPUc2RYj9w6KWdEElYSp4.png',
                        'sub_title' => 'Open Trade',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                10 =>
                    array (
                        'id' => 254,
                        'landing_page_id' => 1,
                        'serial' => 4,
                        'image' => 'landing/process/jLSQIblFCDuzo2YQKQlwxvvCA8ajShB7tKtG6sM3.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                11 =>
                    array (
                        'id' => 255,
                        'landing_page_id' => 1,
                        'serial' => 5,
                        'image' => 'landing/process/yEZW14BDdM5Ght3H9MYjCe9Bl8aIMPrJQcH8fM5g.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                12 =>
                    array (
                        'id' => 256,
                        'landing_page_id' => 1,
                        'serial' => 6,
                        'image' => 'landing/process/XXRL0UgIIsJ3PixRZlazqUm5YqRJuiTt9KbgRKbS.png',
                        'sub_title' => 'Make Exchange',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }




    }
}
