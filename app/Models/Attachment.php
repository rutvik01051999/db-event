<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'collection',
        'attachmentable_id',
        'attachmentable_type',
        'question_index',
        'event_id',
        'default_id'
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}