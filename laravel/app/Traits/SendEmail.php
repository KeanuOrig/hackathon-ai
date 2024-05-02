<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

trait SendEmail {

    public function email($data, $laravel_blade, $to_email, $cc_email, $bcc_email) 
    {   
        $subject = 'Onboarding of New Company - '. $data['name'];
    
        return Mail::send($laravel_blade, $data, function($message) use ($to_email, $cc_email, $bcc_email, $subject) {
            $message->subject($subject)
                ->to($to_email)
                ->cc($cc_email)
                ->bcc($bcc_email);
        });
    }
}