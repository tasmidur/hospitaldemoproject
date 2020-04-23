<?php
namespace App\CustomDir;

class SmsSend{
    public static function sms($data){
        $message=$data['message'];
        $to =$data['contact'];
        $token = "2da9cf2a837dab4d3c4263677d154985";
        $url = "http://api.greenweb.com.bd/api.php";

        $data= array(
            'to'=>"$to",
            'message'=>"$message",
            'token'=>"$token"
        ); // Add parameters in key value
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, 'hillTourismbd');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $smsresult = curl_exec($ch);
    }
}