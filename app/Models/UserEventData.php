<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventData extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'question_index',
        'personal_index',
        'image',
        'input_text',
        'option_val',
        'option_types',
        'personal_id'
    ];

    /**
     * Get the user's attachments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'event_id', 'event_id')->where('index_no', $this->question_index);
    }
}
