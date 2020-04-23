<?php
namespace App\CustomDir;
use Keygen;
use PDF;
class InvoiceGenerator{
   public static function getInvoice(){
    return Keygen::numeric(6)->prefix(mt_rand(1, 9))->generate(true);
   }
   public static function getHotelpdfInvoice($data){
      $pdf = PDF::loadView('mail.hotel-invoice',$data);
      $path = public_path('pdf/');
      $fileName =  time() . '.' . 'pdf';
      $invoicepath='pdf/'. $fileName;
      $pdf->save($path . '/' . $fileName);
      
      $patharray=array(
         'pdfrowfile'=>$pdf->output(),
         'filename'=>$invoicepath,
      );
      return $patharray;
   }
}