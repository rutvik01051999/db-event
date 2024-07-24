<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OptionTypes;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OptionTypes::create([
            'name' => 'Test User',
        ]);

        OptionTypes::create([
            'name' => 'Test User',
        ]);
        OptionTypes::create([
            'name' => 'Test User',
        ]);
        OptionTypes::create([
            'name' => 'Test User',
        ]);
        OptionTypes::create([
            'name' => 'Test User',
        ]);
    }
}
