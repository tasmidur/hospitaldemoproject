<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LetsTalkMailSender extends Mailable
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
        return $this->view('mail.letstalkmail')
                     ->from('hilltourismbd@gmail.com')
                     ->with([
                        'name'=>$this->data['name'],
                        "phone"=>$this->data['phone'],
                        'domain'=>$this->data['domain'],
                        'msg'=>$this->data['msg'],
                        'email'=>$this->data['email']
                    ])
                    ->replyTo($this->data['email'], $this->data['name'])
                    ->subject("LetsTalks To ".$this->data['name']);
    }
}
