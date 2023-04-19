<?php

use App\Model\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::firstOrCreate(
            ['question' => 'What is pexeer ?'],
            [
            'unique_code' => uniqid().date('').time(),
            'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
            'author' => 1
            ]
        );
        Faq::firstOrCreate(
            ['question' => 'How it works ?'],
            [
            'unique_code' => uniqid().date('').time(),
            'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
            'author' => 1
            ]
        );
        Faq::firstOrCreate(
            ['question' => 'What is the workflow ?'],
            [
            'unique_code' => uniqid().date('').time(),
            'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
            'author' => 1
            ]
        );
        Faq::firstOrCreate(
            [ 'question' => 'How i place a order ?'],
            [
            'unique_code' => uniqid().date('').time(),
            'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
            'author' => 1
            ]
        );
        Faq::firstOrCreate(
            ['question' => 'How i make a withdrawal ?'],
            [
            'unique_code' => uniqid().date('').time(),
            'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
            'author' => 1
            ]
        );
        Faq::firstOrCreate(
            ['question' => 'What about the deposit process ?',],
            [
            'unique_code' => uniqid().date('').time(),
            'answer' => 'Aenean condimentum nibh vel enim sodales scelerisque. Mauris quisn pellentesque odio, in vulputate turpis. Integer condimentum eni lorem pellentesque euismod. Nam rutrum accumsan nisl vulputate.',
            'author' => 1
            ]
        );
    }
}
