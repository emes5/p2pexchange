<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CustomLandingCoinsTempTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_coins_temp')->get()->toArray()) {
            \DB::table('custom_landing_coins_temp')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'landing_page_id' => 1,
                        'serial' => 1,
                        'coin_id' => 7,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => '2021-12-10 13:19:29',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'coin_id' => 2,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => '2021-12-10 13:19:29',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 1,
                        'serial' => 3,
                        'coin_id' => 3,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => '2021-12-10 13:19:29',
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 7,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'coin_id' => 5,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => '2021-12-10 13:19:29',
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 8,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'coin_id' => 5,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => '2021-12-10 13:19:29',
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 91,
                        'landing_page_id' => 1,
                        'serial' => 4,
                        'coin_id' => 6,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                6 =>
                    array (
                        'id' => 95,
                        'landing_page_id' => 3,
                        'serial' => 1,
                        'coin_id' => 1,
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus eleifend elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                7 =>
                    array (
                        'id' => 98,
                        'landing_page_id' => 3,
                        'serial' => 2,
                        'coin_id' => 2,
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus eleifend elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                8 =>
                    array (
                        'id' => 100,
                        'landing_page_id' => 3,
                        'serial' => 3,
                        'coin_id' => 4,
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus eleifend elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                9 =>
                    array (
                        'id' => 101,
                        'landing_page_id' => 1,
                        'serial' => 5,
                        'coin_id' => 8,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                10 =>
                    array (
                        'id' => 102,
                        'landing_page_id' => 1,
                        'serial' => 6,
                        'coin_id' => 7,
                        'sub_description' => 'Buy Bitcoin (BTC) with over 300+ payment methods, from anywhere in the world with BitValve P2P crypto exchange.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                11 =>
                    array (
                        'id' => 103,
                        'landing_page_id' => 3,
                        'serial' => 4,
                        'coin_id' => 6,
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus eleifend elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                12 =>
                    array (
                        'id' => 104,
                        'landing_page_id' => 3,
                        'serial' => 5,
                        'coin_id' => 3,
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus eleifend elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                13 =>
                    array (
                        'id' => 105,
                        'landing_page_id' => 3,
                        'serial' => 6,
                        'coin_id' => 3,
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duiset luctus eleifend elementum. Nulla facilisi. Maecenas non commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
