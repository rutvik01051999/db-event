<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'start_date',
        'close_date',
        'category_id',
        'department_id',
        'event_url'
    ];
}
