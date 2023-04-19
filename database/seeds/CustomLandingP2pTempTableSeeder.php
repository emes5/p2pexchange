<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingP2pTempTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_p2p_temp')->get()->toArray()) {
            DB::table('custom_landing_p2p_temp')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'landing_page_id' => 2,
                        'type' => 1,
                        'serial' => 1,
                        'image' => 'landing/work/4OAO6fcrCs1EIEhav5nGzJeIx64Fh4BGIIjVRcgP.png',
                        'sub_title' => 'Place An Order',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum natus obcaecati vitae neque cumque dolorem ut quos modi tenetur delectus?',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 2,
                        'type' => 1,
                        'serial' => 2,
                        'image' => 'landing/work/fPdLoFLmayEpbdd27d1mpAuDI6jTAEueJilXI0LP.png',
                        'sub_title' => 'Pay The Seller',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum natus obcaecati vitae neque cumque dolorem ut quos modi tenetur delectus?',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 2,
                        'type' => 1,
                        'serial' => 3,
                        'image' => 'landing/work/aUaLdFZZqQi2qiq7X1kTo3OJOBQNH79Wcu9yy2rB.png',
                        'sub_title' => 'Get Your Crypto',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum natus obcaecati vitae neque cumque dolorem ut quos modi tenetur delectus?',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 6,
                        'landing_page_id' => 2,
                        'type' => 2,
                        'serial' => 4,
                        'image' => 'landing/work/5cpkfkWWv8nuouMVU4p2cFJbPS2WqPIwzihaeFlF.png',
                        'sub_title' => 'Place An Order',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum natus obcaecati vitae neque cumque dolorem ut quos modi tenetur delectus?',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 7,
                        'landing_page_id' => 2,
                        'type' => 2,
                        'serial' => 5,
                        'image' => 'landing/work/luEY0QvC1nezSOmhHy2tBzfmT3PimgHyM8ZKexKn.png',
                        'sub_title' => 'Pay The Seller',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum natus obcaecati vitae neque cumque dolorem ut quos modi tenetur delectus?',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 8,
                        'landing_page_id' => 2,
                        'type' => 2,
                        'serial' => 6,
                        'image' => 'landing/work/Fk7V1FEFytRsfOGRAMTeIEJLGMQwS9IefS1pTR4d.png',
                        'sub_title' => 'Get Your Crypto',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum natus obcaecati vitae neque cumque dolorem ut quos modi tenetur delectus?',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }

    }
}
