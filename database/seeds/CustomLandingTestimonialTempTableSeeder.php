<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomLandingTestimonialTempTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('custom_landing_testimonial_temp')->get()->toArray()) {
            DB::table('custom_landing_testimonial_temp')->insert(array (
                0 =>
                    array (
                        'id' => 13,
                        'landing_page_id' => 2,
                        'serial' => 1,
                        'image' => 'landing/testimonial/ymll7y8RdJiVGci3Uzc02Zef7WTuguW3iOpErNfE.jpg',
                        'sub_title' => 'CEO ( Grodins Group )',
                        'sub_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                1 =>
                    array (
                        'id' => 16,
                        'landing_page_id' => 2,
                        'serial' => 2,
                        'image' => 'landing/testimonial/NCAhIRcR2Rzhig6QH9t6WoATw9EKyUagAOyQLLzj.jpg',
                        'sub_title' => 'CEO ( Grodins Group )',
                        'sub_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                2 =>
                    array (
                        'id' => 17,
                        'landing_page_id' => 2,
                        'serial' => 3,
                        'image' => 'landing/testimonial/JyzXXpKFFE0PQbtsLfhsngnCF3oiQpQWpnTLdPTP.jpg',
                        'sub_title' => 'CEO ( Grodins Group )',
                        'sub_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt vitae odio laboriosam exercitationem quos eum!',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array (
                        'id' => 18,
                        'landing_page_id' => 3,
                        'serial' => 1,
                        'image' => 'landing/testimonial/MCPWMD2mDr8brkCux9iju9o6HelqbTjqRiQ3S7xd.png',
                        'sub_title' => 'Samanta William',
                        'sub_description' => 'Donec tristique commodo massa, prtiu egestas metus luctus eu. Morbi consequat scelerisque mauris sit amet dignissim.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array (
                        'id' => 20,
                        'landing_page_id' => 3,
                        'serial' => 2,
                        'image' => 'landing/testimonial/Dpzk7AlIoOApts5FzZ1EqXbk5nOVmP5BmUn7mS8n.png',
                        'sub_title' => 'Jhon Doe',
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duis luctus eleifend elementum. Nulla facilisi. Maecenas no commodo risus. Orci varius
natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
Sed
facilisis rhoncus lorem sit amet commodo. Nulla tincidunt volutpa.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array (
                        'id' => 45,
                        'landing_page_id' => 2,
                        'serial' => 4,
                        'image' => 'landing/testimonial/IU4BOa2fhKQaGUy7N9NAFlY9aEZlmpms2qGlaY2d.jpg',
                        'sub_title' => 'CEO ( Grodins Group )',
                        'sub_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea possimus iusto adipisci voluptas dolor vitae, tempore, neque nulla, laudantium veniam accusantium. Laborum corporis odio harum vero. Tenetur maxime adipisci reprehenderit necessitatibus numquam suscipit asperiores, eos ipsam exercitationem a voluptates ipsa molestiae quae neque minima deleniti minus aliquid aperiam amet saepe.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                6 =>
                    array (
                        'id' => 47,
                        'landing_page_id' => 1,
                        'serial' => 1,
                        'image' => 'landing/testimonial/zM8JIS8ZIfJtJSV0RQDMDzPBEfXxHI3CD0wmj48F.jpg',
                        'sub_title' => 'Samanta William',
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duis luctus eleifend elementum. Nulla facilisi. Maecenas no commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed facilisis rhoncus lorem sit amet commodo. Nulla tincidunt volutpa.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                7 =>
                    array (
                        'id' => 48,
                        'landing_page_id' => 1,
                        'serial' => 2,
                        'image' => 'landing/testimonial/bGrjRN3WQgCAMWMlAbCWO9I9ZdXPOHqdsVTeSOk9.jpg',
                        'sub_title' => 'John Doe',
                        'sub_description' => 'Fusce dui erat, efficitur ac nibh eget, tristique lobortis erat. Duis luctus eleifend elementum. Nulla facilisi. Maecenas no commodo risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed facilisis rhoncus lorem sit amet commodo. Nulla tincidunt volutpa.',
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));
        }

    }
}
