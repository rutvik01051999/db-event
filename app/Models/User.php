<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,  HasRoles;

    /**
     * Get user data at login time
     *
     * @version 1.0
     * @uses    WEB
     * @param   string $user
     * @param   string $password
     * @return  array
     * @author  Jeetendrasinh Parmar <jeetendrasinh.parmar@bytestechnolab.in>
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'full_name',
        'first_name',
        'mid_name',
        'last_name',
        'date_of_birth',
        'gender',
        'division',
        'location',
        'state',
        'city',
        'country',
        'department',
        'sub_department',
        'status',
        'username',
        'phone_number',
        'designation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id');
    }
}
