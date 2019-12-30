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
        $route = '';
        $prefix = request()->route()->getPrefix();

        if(isset($prefix)) {
            $route = route('e.emails.create');
        } else {
            $route = route('emails.create');
        }

        // if email was set to be sent at a specific schedule,
        if (isset($data['scheduled_at'])) {
            $delay = Carbon::parse($data['scheduled_at']);
            JobsSendEmail::dispatch($data)->delay($delay);

            return redirect($route)->with(
                'message', [
                    'status' => 'info',
                    'text' => 'Message has been successfully scheduled.'
                ]
            );  
        } else {
            // send immediately
            JobsSendEmail::dispatch($data);

            return redirect($route)->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Message successfully sent.'
                ]
            );  
        }
    }
}
