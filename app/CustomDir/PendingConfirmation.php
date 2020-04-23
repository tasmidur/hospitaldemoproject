<?php

namespace App\CustomDir;
use DB;
use App\Jobs\HotelInvoiceSender;
use App\Jobs\InvoiceSMS;
use Carbon\Carbon;
use Mail;
use App\Mail\HotelInvoiceMail;


class PendingConfirmation{

    public static function pendingConfirmation_invociesend($invoice_data,$paidfare,$key){


        $hotelinfo=DB::table('hotels')
           ->where('hotels_id',$key)
           ->get();

           $sellerinfo=array();

           foreach($hotelinfo as $info){
           $sellerinfo['sellername']=$info->hotels_name;
           $sellerinfo['sellercontact']=$info->hotels_num;
           $sellerinfo['sellerlocation']=$info->hotels_location;
           }


          $invoice="";

          $customerinfo=array();
          foreach($invoice_data->customer_info as $info){
            $customerinfo['customer_name']=$info->customer_name;
            $customerinfo['customer_email']=$info->customer_email;
            $customerinfo['customer_contact']=$info->customer_contact_no;
            $customerinfo['customer_address']=$info->customer_address;
            $customerinfo['invoice']=$info->invoice;
            $customerinfo['issuedate']=Carbon::now()->format('Y-m-d');
            $customerinfo['booking_type']='agent';
          }




          $termsandcondition=DB::table('terms_and_condition')
          ->where('condition_type',1)
          ->limit(1)
          ->get();

        $bookingcondition=array();
        foreach($termsandcondition as $tac){
        $bookingcondition['booking_condition']=$tac->booking_condition;
        $bookingcondition['cancel_condition']=$tac->cancel_condition;
        $bookingcondition['change_condition']=$tac->change_condition;
        }

        $termsandcondition=DB::table('terms_and_condition')
                          ->where('condition_type',1)
                          ->limit(1)
                          ->get();

        $bookingcondition=array();

        foreach($termsandcondition as $tac){
        $bookingcondition['booking_condition']=$tac->booking_condition;
        $bookingcondition['cancel_condition']=$tac->cancel_condition;
        $bookingcondition['change_condition']=$tac->change_condition;
        }

        $invoice=array(
        'invoice'=>"#".$customerinfo['invoice'],
        'seller'=>$sellerinfo,
        'customer'=>$customerinfo,
        'product'=>$invoice_data->reserve_info,
        'condition'=>$bookingcondition,
        'payed_fare'=>$paidfare,
        'poweredby'=>'hilltourismbd.com',
        'email'=>$customerinfo['customer_email'],
        'contact'=>$customerinfo['customer_contact']
        );

        $status_msg['status']=1;
        $invoicepath=InvoiceGenerator::getHotelpdfInvoice($invoice);
        $data['invoice_path']=$invoicepath['filename'];
        $status_msg['invoice_path']=url('/')."/".$invoicepath['filename'];
        $customerinfo['pdfurl']= $status_msg['invoice_path'];
        //job dispatch
        $emailJob = new HotelInvoiceSender($customerinfo);

        $message="Hi, ".$customerinfo['customer_name']." Successfully confirmed your booking, please check email, Invocie #".$customerinfo['invoice'];
        $message.=' powered by hilltourismbd.com';
        //parameter 
        //contact
        //message

        $smsdata=array(
            "contact"=>$customerinfo['customer_contact'],
            "message"=>$message
        );

        
        $sms=new InvoiceSMS($smsdata);
        
        dispatch($sms)->delay(Carbon::now()->addSeconds(30));        
        dispatch($emailJob)->delay(Carbon::now()->addSeconds(20));
        $email = new HotelInvoiceMail($customerinfo);
        Mail::to($customerinfo['customer_email'])->send($email);   
        return 1;
    }
}