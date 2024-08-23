<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
        'event_url',
        'response',
        'status'
    ];
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    public function personalinfo(): HasMany
    {
        return $this->hasMany(PersonalInformation::class);
    }
    
}
