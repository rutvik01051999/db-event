<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = 53042;
        $password = '$2y$12$XoDt0VEgqcQfLS8SagVuO.RbtHhEUUhCpP0T1f7c9FuECif0zn1E2';

        $userData = Employee::getUserDetails($username);
        $name = $userData['DISPLAYNAME'];
        $email = $userData['EMAIL'];
        $designation = $userData['DESIGNATION'];
        $employeeId  = $username = $userData['EMPLOYEEID'];
        $phoneNumber = $userData['MOBILE'];
        list($firstName, $lastName) = explode(' ', $name);

        $user = User::updateOrCreate([
            'username' => $username
        ], [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'employee_id' => $employeeId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone_number' => $phoneNumber,
            'designation' => $designation,
        ]);

        $user->assignRole('super-admin');

        // Sync permissions
        $permissions = Permission::all();

        $user->syncPermissions($permissions);
    }
}
