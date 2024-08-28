<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventPersonalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'age',
        'address',
        'pincode',
        'area',
        'state',
        'city',
        'mobile_number',
        'dob'
    ];

    public function events()
    {
        return $this->hasMany(UserEventData::class, 'personal_id', 'id');
    }
}
