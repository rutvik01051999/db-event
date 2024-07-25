<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'required',
        'option_types',
        'option_name'
    ];
}
