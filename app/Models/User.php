<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'employee';
    protected $primaryKey = 'EMPLOYEECODE';
    public $timestamps = false;
    protected $connection = 'matrix_db';
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

    // User Data
    public static function getUserDetails($userName): array
    {
        $selectable = [
            'DISPLAYNAME',
            'EMPLOYEECODE',
            'CENTERCODE',
            'DESKCODE',
            'DESKS',
            'PHONERES',
            'MOBILE',
            'EMAIL',
            'EMPLOYEEID',
            'DESIGNATION',
            'GROUPCODE',
            'PHONEOFF',
            'CENTERNAME',
            'PHONEOFF',
            'picture_new',
            'KEYBOARD',
            'default_theme',
            'mycloud_last_login'
        ];

        $query = self::select($selectable);
        // DBCL user
        $result = $query->where('PHONERES', $userName)->first()->toArray();
        return $result;
    }
}
