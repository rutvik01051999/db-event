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
        $departments = [
            [
                'name' => 'Ad Portal',
            ],
            [
                'name' => 'Ad Sales',
            ],
            [
                'name' => 'AD Sales & Marketing',
            ],
            [
                'name' => 'Administration',
            ],
            [
                'name' => 'Brand Communications',
            ],
            [
                'name' => 'Brand Marketing',
            ],
            [
                'name' => 'Business Development',
            ],
            [
                'name' => 'Circulation',
            ],
            [
                'name' => 'Circulation Sales',
            ],
            [
                'name' => 'Corporate',
            ],
            [
                'name' => 'Corporate Contract',
            ],
            [
                'name' => 'Corporate Sales',
            ],
            [
                'name' => 'CSR',
            ],
            [
                'name' => 'Deputy MD Office',
            ],
            [
                'name' => 'Digital',
            ],
            [
                'name' => 'Directors Office',
            ],
            [
                'name' => 'Editorial',
            ],
            [
                'name' => 'Engineering',
            ],
            [
                'name' => 'Finance & Accounts',
            ],
            [
                'name' => 'HR & Admin',
            ],
            [
                'name' => 'Information Technology',
            ],
            [
                'name' => 'Investor Relations',
            ],
            [
                'name' => 'Marketing',
            ],
            [
                'name' => 'MD Office',
            ],
            [
                'name' => 'Media School',
            ],
            [
                'name' => 'Non- Technical',
            ],
            [
                'name' => 'Operations',
            ],
            [
                'name' => 'Operations & Maintenance',
            ],
            [
                'name' => 'Power Sales',
            ],
            [
                'name' => 'Product',
            ],
            [
                'name' => 'Production',
            ],
            [
                'name' => 'Programming',
            ],
            [
                'name' => 'Projects',
            ],
            [
                'name' => 'Promoters',
            ],
            [
                'name' => 'Sales',
            ],
            [
                'name' => 'Sales-Ops',
            ],
            [
                'name' => 'Technology',
            ],
            [
                'name' => 'Special Projects',
            ],
        ];

        Departmen::insert($departments);
    }
}
