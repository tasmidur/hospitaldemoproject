<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistermail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.userregistermail')
        ->from('hilltourismbd@gmail.com')
        ->with([
           'name'=>$this->data['name'],
           "username"=>$this->data['email'],
           'password'=>$this->data['password'],
           'flag'=>$this->data['flag']
       ])
       ->replyTo('hilltourismbd@gmail.com')
       ->subject("User Register Information");
    }
}
