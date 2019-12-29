<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'id',
        'sender_name',
        'sender_email',
        'recipient_name',
        'recipient_email',
        'message',
        'sent_at',
        'scheduled_at',
    ];
}
