<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departmen;

class DepartmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departmen::create([
            'name' => 'depart1',
        ]);

        Departmen::create([
            'name' => 'depart2',
        ]);
    }
}
