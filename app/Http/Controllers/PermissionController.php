<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function assign()
    {
        return view('auth.permissions.assign');
    }

    public function store(Request $request)
    {
        $permissions = $request->permissions ?? [];
        $username = $request->username;

        $user = User::where('username', $username)->latest()->first();

        $user->syncPermissions($permissions);

        return redirect()->route('permission.assign')->withSuccess('Permissions assigned successfully');
    }

    public function searchByEmployeeId(Request $request)
    {
        $empId = $request->id;

        $response = Http::withHeaders([
            'Authorization' => 'Basic TUFUUklYOnVvaT1rai1YZWxGa3JvcGVbUllCXXVu',
        ])->asMultipart()->post('https://mdm.dbcorp.co.in/getEmployees', [
            [
                'name' => 'EMPID',
                'contents' => $empId,
            ],
        ]);

        if ($response->failed()) {
            return [];
        }

        $employee = $response->json();
        $name = data_get($employee, 'EMPLOYEE.full_name');
        $email = data_get($employee, 'EMPLOYEE.email_address');
        $password = data_get($employee, 'EMPLOYEE.password');
        $employee_id = data_get($employee, 'EMPLOYEE.EMPID');
        $full_name = data_get($employee, 'EMPLOYEE.full_name');
        $first_name = data_get($employee, 'EMPLOYEE.first_name');
        $mid_name = data_get($employee, 'EMPLOYEE.mid_name');
        $last_name = data_get($employee, 'EMPLOYEE.last_name');
        $date_of_birth = data_get($employee, 'EMPLOYEE.date_of_birth');
        $gender = data_get($employee, 'EMPLOYEE.gender');
        $division = data_get($employee, 'EMPLOYEE.division');
        $location = data_get($employee, 'EMPLOYEE.location');
        $state = data_get($employee, 'EMPLOYEE.state');
        $city = data_get($employee, 'EMPLOYEE.city');
        $country = data_get($employee, 'EMPLOYEE.country');
        $department = data_get($employee, 'EMPLOYEE.department');
        $sub_department = data_get($employee, 'EMPLOYEE.sub_department');
        $username = data_get($employee, 'EMPLOYEE.username');
        $phone_number = data_get($employee, 'EMPLOYEE.phone_number');
        $designation = data_get($employee, 'EMPLOYEE.designation');

        $user = User::where('username', $username)->latest()->first();

        if (!$user) {
            $user = User::create([
                'name' =>  $name,
                'email' => $email,
                'password' => Hash::make($password),
                'employee_id' => $employee_id,
                'first_name' => $first_name,
                'mid_name' => $mid_name,
                'last_name' => $last_name,
                'date_of_birth' => $date_of_birth,
                'gender' => $gender,
                'division' => $division,
                'location' => $location,
                'state' => $state,
                'city' => $city,
                'country' => $country,
                'department' => $department,
                'sub_department' => $sub_department,
                'username' => $username,
                'phone_number' => $phone_number,
                'designation' => $designation
            ]);
        }

        $permissions = Permission::select('id', 'name', 'collection')->get()->groupBy('collection');

        $userPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        $view = view('auth.permissions.all', compact('permissions', 'userPermissions'))->render();

        return response()->json([
            'view' => $view,
            'username' => $username,
            'fullName' => $name,
            'user' => $user
        ]);
    }
}
