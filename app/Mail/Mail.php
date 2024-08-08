<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->details['fromEmail'], $this->details['name'])
        ->subject('ISPAJ website')
        ->view('emails.mailTemplate');

        if ($this->details['file']) {
            return $mail->attach(
                $this->details['file']->getRealPath(),
                [
                    'as' => $this->details['file']->getClientOriginalName(),
                    'mime' => $this->details['file']->getMimeType(),
                ]
            );

        }
        return $mail;
    }
}
