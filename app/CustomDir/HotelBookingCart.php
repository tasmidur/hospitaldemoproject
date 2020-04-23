<?php
namespace App\CustomDir;
use Cache;

class HotelBookingCart{

    public static function addhotelbookingcart($key){
        $arr=[1,2,3,4];
    Cache::put($key,$arr, now()->addMinutes(1));   
    }
    public static function getHotelBookingCart($key){
        return Cache::get($key);
    }
}