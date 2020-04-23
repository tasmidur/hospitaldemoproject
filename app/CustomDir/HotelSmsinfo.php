<?php
namespace App\CustomDir;
use DB;

class HotelSmsinfo{
    public static function hotelcontact($key){
        $hotelinfo=DB::table('hotel_booking_history')
        ->join('hotels','hotel_booking_history.hotels_id','=','hotels.hotels_id')
        ->select('hotels.hotels_num')
        ->where('hotel_booking_history.invoice',$key)
        ->where("hotels.status",1)
        ->limit(1)
        ->get();

        $contact="";

        foreach($hotelinfo as $info){
            $contact=$info->hotels_num;
        }
    return $contact;
    }
}
