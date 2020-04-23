<?php
namespace App\CustomDir;
use Cache;
use Browser;
use DB;
use Carbon\Carbon;
class Visitors{
     
    public static function visit($ip){

    $visitor_id=$ip.Browser::browserFamily().Browser::browserVersion().Browser::platformName().Browser::deviceFamily();
    $check_visitor=DB::table('views')
        ->where('visitor_id',$visitor_id)
        ->get();
    if($check_visitor->count()==0){
        DB::table('views')
        ->insert([
            'visitor_id'=> $visitor_id,
            'viewed_at'=>Carbon::now('Asia/Dhaka'),
        ]);
    }
    }

    public static function countVisitor(){
        $check_visitor=DB::table('views')
                      ->get();
        return $check_visitor->count();
    }

}