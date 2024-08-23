<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'latitude',
        'longitude',
        'suburb',
        'town',
        'county',
        'state_district',
        'state',
        'postcode',
        'country'
    ];
}
