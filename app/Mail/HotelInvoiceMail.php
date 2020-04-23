<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HotelInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $data,$pdf;
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
        return $this->view('mail.hotel-invoicemasg')  //only show the message infromation with customer name,invoice and pdf path
                    ->from('hilltourismbd@gmail.com')
                    ->with([
                        'customer_name'=>$this->data['customer_name'],
                        'invoice'=>$this->data['invoice'],
                        'pdfurl'=>$this->data['pdfurl']
                    ])
                    ->subject('Hotel Booking Confirmation Information');
                
    }
}
