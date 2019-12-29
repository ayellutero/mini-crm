<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail as JobsSendEmail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmailsController extends Controller
{

    public function create()
    {
        return view('emails.create');
    }

    public function send(Request $request)
    {
        $data = $request->all();

        // if email was set to be sent at a specific schedule,
        if (isset($data['scheduled_at'])) {
            $delay = Carbon::parse($data['scheduled_at']);
            JobsSendEmail::dispatch($data)->delay($delay);

            return redirect()->route('emails.create')->with(
                'message', [
                    'status' => 'info',
                    'text' => 'Message has been successfully scheduled.'
                ]
            );  
        } else {
            // send immediately
            JobsSendEmail::dispatch($data);

            return redirect()->route('emails.create')->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Message successfully sent.'
                ]
            );  
        }
    }
}
