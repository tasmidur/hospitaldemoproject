<?php
namespace App\CustomDir;
use DB;

class RawSql{
    //get avaiable room checkin checkout day wise for hotelbooking

    public static function categorywisedata($hotel_id,$checkin,$checkout,$room_category){
        $hotel_room_no=array();
        $hotelsearch=DB::table('hotel_booking_history')
           ->join("hotel_category",function($join){
                $join->on("hotel_booking_history.hotels_id","=",'hotel_category.hotels_id');
                $join->on("hotel_booking_history.room_category_id","=",'hotel_category.room_category_id');
            })
  
            ->join("hotel_room",function($join){
                $join->on('hotel_booking_history.hotels_id','=','hotel_room.hotels_id');
                $join->on('hotel_booking_history.room_category_id','=','hotel_room.room_category_id');
            })
  
            ->select(DB::raw("CONCAT(hotel_booking_history.room_category_id,hotel_booking_history.room_no) as room_no"))
            ->groupBy("hotel_booking_history.room_no")
  
            ->where(function($q) use($checkin,$checkout){
  
              $q->whereBetween('hotel_booking_history.checkin', [$checkin, $checkout])
                   
               ->orwhereBetween('hotel_booking_history.checkout', [$checkin, $checkout]);
               
                if('hotel_booking_history.checkin' < $checkin){
                  $q->orwhere('hotel_booking_history.checkin',"<",$checkin);
                 }
                if('hotel_booking_history.checkout' > $checkout){
                  $q->orwhere('hotel_booking_history.checkout',">",$checkout);
                 }
               
  
             })
       
           ->where(function($q2) use($hotel_id,$room_category){
            return $q2
             ->where('hotel_booking_history.hotels_id','=',$hotel_id)
             ->where('hotel_room.room_category_id','=',$room_category);
            })
            ->where('hotel_category.status',1)
            ->whereIn('hotel_booking_history.booking_status',[1,5])
            ->get();
  
            if($hotelsearch->count()>0){
                foreach ($hotelsearch as  $v) {
                      array_push($hotel_room_no,$v->room_no);
               
                }
            }
  
          
            $avaiable_hotel_room=DB::table("hotel_category")
           ->join('hotels','hotel_category.hotels_id','=','hotels.hotels_id')
           ->join("hotel_room",function($join){
                $join->on('hotel_category.hotels_id','=','hotel_room.hotels_id');
                $join->on('hotel_category.room_category_id','=','hotel_room.room_category_id');
            })
            ->select("hotel_category.*",'hotels.hotels_num','hotels.hotel_services',DB::raw("COUNT(hotel_room.room_category_id) as availableroom"))
            ->where('hotel_category.status',1)
            ->where('hotels.status',1)
            ->where('hotel_category.hotels_id',$hotel_id)
            ->where('hotel_room.room_category_id',$room_category)
            ->whereNotIn(DB::raw("CONCAT(hotel_room.room_category_id,hotel_room.room_no)"),$hotel_room_no)
            ->get();  
           
            return $avaiable_hotel_room;
        }

        public static function allhotelCategorywisedata($room_category,$hotel_id){
            $hotel_room_no=array();
            $hotelsearch=DB::table('hotel_booking_history')
               ->join("hotel_category",function($join){
                    $join->on("hotel_booking_history.hotels_id","=",'hotel_category.hotels_id');
                    $join->on("hotel_booking_history.room_category_id","=",'hotel_category.room_category_id');
                })
      
                ->join("hotel_room",function($join){
                    $join->on('hotel_booking_history.hotels_id','=','hotel_room.hotels_id');
                    $join->on('hotel_booking_history.room_category_id','=','hotel_room.room_category_id');
                })
      
                ->select(DB::raw("CONCAT(hotel_booking_history.room_category_id,hotel_booking_history.room_no) as room_no"))
                ->groupBy("hotel_booking_history.room_no")
           
               ->where(function($q2) use($room_category){
                return $q2
                 ->where('hotel_room.room_category_id','=',$room_category);
                })
                ->where('hotel_category.status',1)
                ->get();
      
                if($hotelsearch->count()>0){
                    foreach ($hotelsearch as  $v) {
                          array_push($hotel_room_no,$v->room_no);
                   
                    }
                }
      
              
                $avaiable_hotel_room=DB::table("hotel_category")
               ->join('hotels','hotel_category.hotels_id','=','hotels.hotels_id')
               ->join("hotel_room",function($join){
                    $join->on('hotel_category.hotels_id','=','hotel_room.hotels_id');
                    $join->on('hotel_category.room_category_id','=','hotel_room.room_category_id');
                })
                ->select("hotel_category.*",'hotels.hotels_num','hotels.hotel_services',
                DB::raw("COUNT(hotel_room.room_category_id) as availableroom"))
                ->where('hotel_category.status',1)
                ->where('hotels.status',1)
                ->where('hotel_category.hotels_id',$hotel_id)
                ->where('hotel_room.room_category_id',$room_category)
                ->whereNotIn(DB::raw("CONCAT(hotel_room.room_category_id,hotel_room.room_no)"),$hotel_room_no)
                ->get();  
               
                return $avaiable_hotel_room;
        }
}