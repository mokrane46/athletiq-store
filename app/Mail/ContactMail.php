<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), 'Athletiq Contact Form')
                    ->replyTo($this->data['email'], $this->data['name'])
                    ->subject('New Contact Message from ' . $this->data['name'])
                    ->view('email')
                    ->with('data', $this->data);
    }
}
