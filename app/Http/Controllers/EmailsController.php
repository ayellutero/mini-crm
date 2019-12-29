<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailsController extends Controller
{

    public function create()
    {
        return view('emails.create');
    }

    public function send(Request $request)
    {
        $data = $request->all();

        if (isset($data['scheduled_at'])) {
            $when = \DateTime::createFromFormat('Y-m-d H:i', $data['scheduled_at']);
            Mail::to($data['recipient_email'])->later($when, new SendEmail($data));

            return redirect()->route('emails.create')->with(
                'message', [
                    'status' => 'info',
                    'text' => 'Message has been successfully scheduled.'
                ]
            );  
        } else {
            Mail::to($data['recipient_email'])->queue(new SendEmail($data));

            if(count(Mail::failures()) > 0){
                return redirect()->route('emails.create')->with(
                    'message', [
                        'status' => 'danger',
                        'text' => 'There was an error sending your email. Please try again.'
                    ]
                ); 
            }

            return redirect()->route('emails.create')->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Message sent successfully.'
                ]
            );  
        }
    }
}
