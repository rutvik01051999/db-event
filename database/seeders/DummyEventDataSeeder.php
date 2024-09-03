<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\UserEventData;
use App\Models\UserEventPersonalData;
use App\Services\AttachmentService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use function Laravel\Prompts\info;
use function Laravel\Prompts\table;

class DummyEventDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::where('status', 1)->latest()->first();

        $startDate = $event->start_date;
        $closeDate = $event->close_date;

        $randomDate = $this->getRandomDateBetween($startDate, $closeDate);

        Carbon::setTestNow($randomDate);

        // Random india pincode
        $pincodes = $this->pincodes();
        $pincode = $pincodes[array_rand($pincodes)];
        $url = "https://api.postalpincode.in/pincode/$pincode";

        $response = Http::get($url)->json();
        $status = data_get($response, '0.Status');

        while ($status != 'Success') {
            $pincode = $pincodes[array_rand($pincodes)];
            $url = "https://api.postalpincode.in/pincode/$pincode";

            $response = Http::get($url)->json();
            $status = data_get($response, '0.Status');
        }

        $postOffices = data_get($response, '0.PostOffice');
        // Pick random post office
        $postOffice = $postOffices[array_rand($postOffices)];

        $area = $postOffice['Name'];
        $state = $postOffice['State'];
        $city = $postOffice['District'];

        $userPersonalInfo = [
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'age' => fake()->numberBetween(18, 60),
            'address' => fake()->address(),
            'pincode' => fake()->numberBetween(100000, 999999),
            'area' => $area,
            'state' => $state,
            'city' => $city,
            'mobile_number' => fake()->numberBetween(1000000000, 9999999999),
            'dob' => fake()->date(),
        ];

        $userPersonalInfo = UserEventPersonalData::create($userPersonalInfo);

        $questions = $event->questions;

        foreach ($questions as $question) {
            $type = $question->option_types;

            $answer = '';
            $files = [];
            switch ($type) {
                case 'input':
                    $answer = fake()->sentence();
                    break;

                case 'checkbox':
                case 'radio':
                case 'dropdown':
                    $limit = $type == 'checkbox' ? rand(1, 3) : 1;
                    $options = $question->options()->inRandomOrder()->limit($limit)->pluck('index_no')->toArray();
                    $answer = implode(',', $options);
                    break;

                case 'textarea':
                    $answer = fake()->paragraph();
                    break;

                case 'date':
                    $answer = fake()->date();
                    break;

                case 'image':
                case 'image_multiple':
                    $totalFiles = $type == 'image' ? 1 : fake()->numberBetween(2, 3);
                    for ($i = 0; $i < $totalFiles; $i++) {
                        $pathToSave = 'event_images/' . $event->id . '/' . $question->index_no;
                        $filename = time() . '.png';

                        // Random image
                        $url = 'https://picsum.photos/1200/800';
                        if (Storage::disk('public')->put($pathToSave . '/' . $filename, Http::get($url)->body())) {
                            $path = Storage::disk('public')->path($pathToSave . '/' . $filename);
                            $file = new UploadedFile($path, $filename, 'image/png', null, true);
                            $files[] = $file;
                        }
                    }
                    break;

                case 'rating':
                    $answer = fake()->numberBetween(1, 5);

                case 'number':
                    $answer = fake()->numberBetween(1, 100000);

                default:
                    $answer = fake()->sentence();
                    break;
            }

            $answerArr = [
                'event_id' => $event->id,
                'question_index' => $question->index_no,
                'option_val' => $answer,
                'option_types' => $type,
                'personal_id' => $userPersonalInfo->id,
                'question_id' => $question->id,
            ];

            $userEvent = UserEventData::create($answerArr);

            $filePaths = [];

            foreach ($files as $file) {
                $attachment = AttachmentService::save($file, 'user-uploaded-file', 'users/uploaded-files', $userEvent);

                if ($attachment) {
                    $filePaths[] = $attachment->file_path;
                }
            }

            if (!empty($filePaths)) {
                $userEvent->update(['option_val' => json_encode($filePaths)]);
            }
        }

        info('Dummy Response seeded successfully');
    }

    public function pincodes()
    {
        $pincodes = [
            '110001',
            '400001',
            '600001',
            '700001',
            '560001',
            '500001',
            '380001',
            '302001',
            '682001',
            '751001',
            '248001',
            '226001',
            '144001',
            '462001',
            '492001',
            '122001',
            '180001',
            '500081',
            '641001',
            '462016',
            '110092',
            '400080',
            '600040',
            '700091',
            '560100',
            '500072',
            '380015',
            '302015',
            '682020',
            '751019',
            '248009',
            '226010',
            '144005',
            '462007',
            '492007',
            '122003',
            '180004',
            '500090',
            '641004',
            '462023',
            '110055',
            '400067',
            '600073',
            '700039',
            '560079',
            '500084',
            '380007',
            '302020',
            '682025',
            '751012',
            '248006',
            '226022',
            '144201',
            '462030',
            '492012',
            '122006',
            '180002',
            '500016',
            '641014',
            '462001',
            '110012',
            '400013',
            '600032',
            '700047',
            '560001',
            '500039',
            '380009',
            '302033',
            '682015',
            '751019',
            '248002',
            '226008',
            '144210',
            '462013',
            '492004',
            '122011',
            '180003',
            '500008',
            '641016',
            '462026',
            '110029',
            '400062',
            '600087',
            '700094',
            '560017',
            '500063',
            '380023',
            '302028',
            '682030',
            '751013',
            '248003',
            '226016',
            '144204',
            '462021',
            '492009',
            '122004',
            '180005',
            '500080',
            '641011',
            '462008',
        ];

        return $pincodes;
    }

    function getRandomDateBetween($startDate, $endDate)
    {
        return Carbon::parse($startDate)
            ->addDays(rand(0, Carbon::parse($startDate)->diffInDays($endDate)))
            ->toDateString();
    }
}
