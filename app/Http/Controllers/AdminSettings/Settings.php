<?php

namespace App\Http\Controllers\AdminSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use DB;

class Settings extends Controller
{
    public function clearcache(Request $request){
        $command=$request->cmd;
        $status=Artisan::call($command);
        echo $status;
    }
    //queuejob

    public function queuejob(){
        Artisan::call('queue:work --sansdaemon');
    }

    //pending request cancellation command

    public function pendingHotelRoomCancellationSchedullar(){
      
        $data=DB::table("hotel_booking_history")
            ->select('invoice')
            ->where('booking_status',5)
            ->where('created_at','<',Carbon::now()->subMinutes(30))
            ->get();
        $invoice=array();
        foreach($data as $item){
            if(!in_array($item->invoice,$invoice)){
                array_push($invoice,$item->invoice);
              }
        }

        if(sizeof($invoice)>0){
            DB::table("hotel_booking_history")
                ->whereIn("invoice",$invoice)
                ->delete();
            DB::table("hotels_reserved_customer_info")
                ->whereIn("invoice",$invoice)
                ->delete();
        }
    }

    // user api config 

   
}
