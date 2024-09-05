<?php

namespace Database\Seeders;

use App\Enums\EventType;
use App\Models\Category;
use App\Models\Event;
use App\Models\Option;
use App\Models\PersonalInformation;
use App\Models\Question;
use App\Services\QrCodeService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\text;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ask for how many event do you want to create using laravel prompt
        $eventCount = text(
            label: 'How many events do you want to create?',
            validate: fn(string $value) => match (true) {
                !is_numeric($value) => 'Please enter a number',
                $value < 0 => 'Please enter a positive number',
                default => null,
            },
        );

        if ($eventCount === null) {
            return;
        }

        $eventCount = (int) $eventCount;

        $progress = progress(label: 'Creating events....', steps: $eventCount);
        for ($i = 0; $i < $eventCount; $i++) {
            $this->createEvent();

            $progress->advance();
        }

        $progress->finish();
    }

    public function createEvent()
    {
        // Convert to file object
        $pathToSave = 'images';
        $filename = time() . '.png';

        // Random image
        $url = 'https://picsum.photos/1200/800';

        // Save image
        Storage::put($pathToSave . '/' . $filename, Http::get($url)->body());
        $filePath = $pathToSave . '/' . $filename;

        $event = Event::create([
            'name' => fake()->name(),
            'description' => fake()->text(),
            'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'close_date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
            'image' => $filePath,
            'category_id' => Category::inRandomOrder()->first()->id,
            'department_id' => Category::inRandomOrder()->first()->id,
            'event_url' => env('APP_URL') . '/' . str()->random(25),
            'response' => 'Thank you! We will get back to you shortly.',
            'status' => true,
            'event_type' => EventType::SINGLE_DAY,
        ]);

        $personalInformations = [
            [
                'index_no' => '0',
                'event_id' => '1',
                'name' => 'Full Name',
                'input_name' => 'full_name',
                'description' => null,
                'required' => '1',
                'option_types' => 'input',
                'option_name' => null,
            ],
            [
                'index_no' => '1',
                'event_id' => '1',
                'name' => 'Gender',
                'input_name' => 'gender',
                'description' => null,
                'required' => '1',
                'option_types' => 'radio',
                'option_name' => 'Male ~ Female ~ Others',
            ],
            [
                'index_no' => '2',
                'event_id' => '1',
                'name' => 'Age',
                'input_name' => 'age',
                'description' => null,
                'required' => '1',
                'option_types' => 'input',
                'option_name' => null,
            ],
            [
                'index_no' => '3',
                'event_id' => '1',
                'name' => 'Address',
                'input_name' => 'address',
                'description' => null,
                'required' => '1',
                'option_types' => 'textarea',
                'option_name' => null,
            ],
            [
                'index_no' => '4',
                'event_id' => '1',
                'name' => 'Pincode',
                'input_name' => 'pincode',
                'description' => null,
                'required' => '1',
                'option_types' => 'pincode',
                'option_name' => null,
            ],
            [
                'index_no' => '5',
                'event_id' => '1',
                'name' => 'Area',
                'input_name' => 'area',
                'description' => null,
                'required' => '1',
                'option_types' => 'input',
                'option_name' => null,
            ],
            [
                'index_no' => '6',
                'event_id' => '1',
                'name' => 'State',
                'input_name' => 'state',
                'description' => null,
                'required' => '1',
                'option_types' => 'input',
                'option_name' => null,
            ],
            [
                'index_no' => '7',
                'event_id' => '1',
                'name' => 'City',
                'input_name' => 'city',
                'description' => null,
                'required' => '1',
                'option_types' => 'input',
                'option_name' => null,
            ],
            [
                'index_no' => '8',
                'event_id' => '1',
                'name' => 'Mobile No',
                'input_name' => 'mobile_number',
                'description' => null,
                'required' => '1',
                'option_types' => 'mobile_otp',
                'option_name' => null,
            ],
        ];

        foreach ($personalInformations as $personalInformation) {
            $question = PersonalInformation::create([
                'event_id' => $event->id,
                'name' => $personalInformation['name'],
                'description' => $personalInformation['description'],
                'required' => $personalInformation['required'],
                'option_types' => $personalInformation['option_types'],
                'index_no' => $personalInformation['index_no'],
                'input_name' => $personalInformation['input_name'],
            ]);

            $options = explode(' ~ ', $personalInformation['option_name']);

            foreach ($options as $k => $option) {
                Option::create([
                    'personal_information_id' => $question->id,
                    'name' => $option,
                    'index_no' => $k,
                ]);
            }
        }

        $questions = [
            [
                'index_no' => '0',
                'event_id' => $event->id,
                'name' => 'What is the capital of Australia?',
                'description' => null,
                'required' => 1,
                'option_types' => 'input',
                'option_name' => null,
                'correct_answer' => 'Canberra',
                'sample_answer' => 'Canberra',
            ],
            [
                'index_no' => '1',
                'event_id' => $event->id,
                'name' => 'Describe the impact of the Industrial Revolution on modern society.',
                'description' => null,
                'required' => 1,
                'option_types' => 'textarea',
                'option_name' => null,
                'correct_answer' => null,
                'sample_answer' => 'The Industrial Revolution led to significant advancements in technology, urbanization, and changes in labor practices, shaping the modern industrialized world.',
            ],
            [
                'index_no' => '2',
                'event_id' => $event->id,
                'name' => 'True or False: The Great Wall of China is visible from space.',
                'description' => null,
                'required' => 1,
                'option_types' => 'checkbox',
                'option_name' => 'True ~ False',
                'correct_answer' => 'False',
                'sample_answer' => 'False',
            ],
            [
                'index_no' => '3',
                'event_id' => $event->id,
                'name' => 'Select the largest ocean on Earth.',
                'description' => null,
                'required' => 1,
                'option_types' => 'dropdown',
                'option_name' => 'Pacific Ocean ~ Atlantic Ocean ~ Indian Ocean ~ Arctic Ocean',
                'correct_answer' => 'Pacific Ocean',
                'sample_answer' => 'Pacific Ocean',
            ],
            [
                'index_no' => '4',
                'event_id' => $event->id,
                'name' => 'Which of the following is the longest river in the world?',
                'description' => null,
                'required' => 1,
                'option_types' => 'radio',
                'option_name' => 'Nile ~ Amazon ~ Yangtze',
                'correct_answer' => 'Nile',
                'sample_answer' => 'Nile',
            ],
            [
                'index_no' => '5',
                'event_id' => $event->id,
                'name' => 'Upload a picture of a historical monument.',
                'description' => 'Please upload an image file.',
                'required' => 1,
                'option_types' => 'image',
                'option_name' => null,
                'correct_answer' => null,
                'sample_answer' => 'Uploaded image file',
            ],
            [
                'index_no' => '6',
                'event_id' => $event->id,
                'name' => 'Select the date of the signing of the Declaration of Independence.',
                'description' => null,
                'required' => 1,
                'option_types' => 'date',
                'option_name' => null,
                'correct_answer' => '1776-07-04',
                'sample_answer' => '1776-07-04',
            ],
            [
                'index_no' => '7',
                'event_id' => $event->id,
                'name' => 'Rate the impact of climate change on the environment (1 to 5).',
                'description' => null,
                'required' => 1,
                'option_types' => 'rating',
                'option_name' => '1 ~ 2 ~ 3 ~ 4 ~ 5',
                'correct_answer' => null,
                'sample_answer' => '4',
            ],
            [
                'index_no' => '8',
                'event_id' => $event->id,
                'name' => 'How many continents are there on Earth?',
                'description' => null,
                'required' => 1,
                'option_types' => 'number',
                'option_name' => null,
                'correct_answer' => '7',
                'sample_answer' => '7',
            ],
            [
                'index_no' => '9',
                'event_id' => $event->id,
                'name' => 'Upload multiple images of famous historical leaders.',
                'description' => 'Please upload multiple image files.',
                'required' => 1,
                'option_types' => 'image_multiple',
                'option_name' => null,
                'correct_answer' => null,
                'sample_answer' => 'Multiple uploaded image files',
            ],
        ];

        foreach ($questions as $question) {
            $question = Question::create([
                'event_id' => $event->id,
                'name' => $question['name'],
                'description' => $question['description'],
                'required' => $question['required'],
                'option_types' => $question['option_types'],
                'option_name' => $question['option_name'],
                'index_no' => $question['index_no'],
            ]);

            $options = explode(' ~ ', $question['option_name']);

            foreach ($options as $k => $option) {
                Option::create([
                    'question_id' => $question->id,
                    'name' => $option,
                    'index_no' => $k,
                    'is_correct' => $option == $question['correct_answer'] ? 1 : 0,
                ]);
            }
        }

        // Save QR Code
        QrCodeService::generateAndSave($event);
    }
}
