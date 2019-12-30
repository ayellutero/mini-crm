<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'sender_name',
        'sender_email',
        'recipient_name',
        'recipient_email',
        'message',
        'scheduled_at',
    ];
}
