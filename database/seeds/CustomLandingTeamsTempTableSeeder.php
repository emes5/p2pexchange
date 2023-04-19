<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingTeamsTempTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_teams_temp')->get()->toArray()) {
            DB::table('custom_landing_teams_temp')->insert(array (
                0 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'image' => 'landing/team/wnVehz0lZfFvkINVWKVAhM0voofEKkuzNi43mtR3.jpg',
                        'sub_title' => 'Alex Grinfield',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatem error ducimus doloremque vel minima sed reprehenderit recusandae unde sit?',
                        'facebook' => 'https://www.link.com/',
                        'linkedin' => 'https://www.link.com/',
                        'twitter' => 'https://www.link.com/',
                        'created_at' => '2021-12-10 13:26:46',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 1,
                        'serial' => 3,
                        'image' => 'landing/team/sg82HzIi60BX4gDTrJNLsjUWCSBcTj9HUq2Ta0to.jpg',
                        'sub_title' => 'Alex Grinfield',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatem error ducimus doloremque vel minima sed reprehenderit recusandae unde sit?',
                        'facebook' => 'https://www.link.com/',
                        'linkedin' => 'https://www.link.com/',
                        'twitter' => 'https://www.link.com/',
                        'created_at' => '2021-12-10 13:26:46',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 5,
                        'landing_page_id' => 1,
                        'serial' => 4,
                        'image' => 'landing/team/jNBZpBDhspTcq4XuKU4CsfSZuLHhbk1cklPpQPEN.jpg',
                        'sub_title' => 'Alex Grinfield',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatem error ducimus doloremque vel minima sed reprehenderit recusandae unde sit?',
                        'facebook' => 'https://www.link.com/',
                        'linkedin' => 'https://www.link.com/',
                        'twitter' => 'https://www.link.com/',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 9,
                        'landing_page_id' => 2,
                        'serial' => 2,
                        'image' => 'landing/team/Y2GFXb6FWRKkFFrbsjxSCRWYai3u5YjlAQnuldCV.jpg',
                        'sub_title' => 'VICKY SMITH',
                        'sub_description' => 'Leader',
                        'facebook' => 'https://www.link.com/',
                        'linkedin' => 'https://www.link.com/',
                        'twitter' => 'https://www.link.com/',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 10,
                        'landing_page_id' => 2,
                        'serial' => 3,
                        'image' => 'landing/team/Fil0zbHGd6sEIjP6NV5znkc2Rn9ugvXrtyRmkwMP.jpg',
                        'sub_title' => 'ROWLING',
                        'sub_description' => 'Team',
                        'facebook' => 'https://www.link.com/',
                        'linkedin' => 'https://www.link.com/',
                        'twitter' => 'https://www.link.com/',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 13,
                        'landing_page_id' => 2,
                        'serial' => 4,
                        'image' => 'landing/team/ruGzbCCGNblpEmKaRxkob0vBdXVEqZk58jAeI4zR.jpg',
                        'sub_title' => 'TUCKER',
                        'sub_description' => 'Team Leader',
                        'facebook' => NULL,
                        'linkedin' => NULL,
                        'twitter' => NULL,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
