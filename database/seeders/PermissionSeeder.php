<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            [
                'name' => 'view dashboard',
                'guard_name' => 'web',
                'collection' => 'dashboard',
            ],
            [
                'name' => 'view events',
                'guard_name' => 'web',
                'collection' => 'event',
            ],
            [
                'name' => 'create/update events',
                'guard_name' => 'web',
                'collection' => 'event',
            ],
            [
                'name' => 'delete events',
                'guard_name' => 'web',
                'collection' => 'event',
            ],
            [
                'name' => 'view event reports',
                'guard_name' => 'web',
                'collection' => 'report',
            ]
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::updateOrCreate(
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ],
                [
                    'collection' => $permission['collection'],
                ]
            );
        }
    }
}
