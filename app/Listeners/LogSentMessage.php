<?php

namespace App\Listeners;

use App\Email;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;

class LogSentMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        \Log::info('Message sent!');
        if (Email::create($event->data['data'])) {
            \Log::info('Email details successfully saved in logs.');
        } else {
            \Log::info('Failed to save email details in logs.');
        }
    }
}
