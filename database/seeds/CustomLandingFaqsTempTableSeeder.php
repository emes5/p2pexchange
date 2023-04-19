<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingFaqsTempTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (!DB::table('custom_landing_faqs_temp')->get()->toArray()) {
            DB::table('custom_landing_faqs_temp')->insert(array (
                0 =>
                    array (
                        'id' => 2,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'question' => 'What is the workflow ?',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum excepturi deserunt quae quos. Sunt, aperiam nostrum. Fuga sint a iste architecto nulla veritatis ab voluptatum illum voluptates!',
                        'created_at' => '2021-12-10 13:28:37',
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 3,
                        'landing_page_id' => 1,
                        'serial' => 3,
                        'question' => 'How i place a order ?',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum excepturi deserunt quae quos. Sunt, aperiam nostrum. Fuga sint a iste architecto nulla veritatis ab voluptatum illum voluptates!',
                        'created_at' => '2021-12-10 13:28:37',
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 4,
                        'landing_page_id' => 1,
                        'serial' => 4,
                        'question' => 'How i make a withdrawal ?',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum excepturi deserunt quae quos. Sunt, aperiam nostrum. Fuga sint a iste architecto nulla veritatis ab voluptatum illum voluptates!',
                        'created_at' => '2021-12-10 13:28:37',
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 7,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'question' => 'What is Lorem Ipsum',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum excepturi deserunt quae quos. Sunt, aperiam nostrum.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 9,
                        'landing_page_id' => 2,
                        'serial' => 2,
                        'question' => 'What is Lorem Ipsum?',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 12,
                        'landing_page_id' => 2,
                        'serial' => 4,
                        'question' => 'What Is Lorem Ipsum',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum excepturi deserunt quae quos. Sunt, aperiam nostrum.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                6 =>
                    array (
                        'id' => 18,
                        'landing_page_id' => 1,
                        'serial' => 6,
                        'question' => 'What is Lorem Ipsum?',
                        'answer' => 'dssdv fddg',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                7 =>
                    array (
                        'id' => 21,
                        'landing_page_id' => 3,
                        'serial' => 5,
                        'question' => 'What is pexeer ?',
                        'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                8 =>
                    array (
                        'id' => 22,
                        'landing_page_id' => 1,
                        'serial' => 7,
                        'question' => 'What is Lorem Ipsum?',
                        'answer' => 'dfg dgdf fd df',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                9 =>
                    array (
                        'id' => 23,
                        'landing_page_id' => 3,
                        'serial' => 6,
                        'question' => 'How it works ?',
                        'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                10 =>
                    array (
                        'id' => 26,
                        'landing_page_id' => 2,
                        'serial' => 5,
                        'question' => 'Why do we use it?',
                        'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt quo minus sint, quaerat quidem eius pariatur vero odio illo assumenda unde placeat, dolorum soluta ratione sunt rerum laborum, laudantium doloribus minima ipsum excepturi deserunt quae quos. Sunt, aperiam nostrum.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                11 =>
                    array (
                        'id' => 27,
                        'landing_page_id' => 3,
                        'serial' => 7,
                        'question' => 'What is the workflow ?',
                        'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                12 =>
                    array (
                        'id' => 28,
                        'landing_page_id' => 3,
                        'serial' => 8,
                        'question' => 'How i place a order ?',
                        'answer' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }
    }
}
