<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestorePassword extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Restablecimiento de contraseña.';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $url)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('restorePassword', ['url' => $this->url]);
    }
}
