<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    public $destination;
    public $template;
    public $params;

    public function __construct($subject,$destination,$template,$params)
    {
        $this->subject     = $subject;
        $this->destination = $destination;
        $this->template    = $template;
        $this->params        = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->template,$this->params);
    }

    public function sendMail() {
        $this->build();
        return Mail::to($this->destination)->queue($this);
    }

    public function sendMailJob(){
        Mail::queue($this->template, $this->params, function ($message){
            $message->from(env("MAIL_USERNAME"), env("APP_NAME")); 
            $message->to($this->destination)->subject($this->subject);
      });
      
    }
}
