<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Illuminate\Database\QueryException;
use Auth;
class ServiceChargeAddController extends Controller
{
    
public function __construct() {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    
    
public function index(){
        
        return view("Admin-User.servicechargeadd");
    }

public function get(Request $request){
       
       if($request->ajax())
        {
            $data = DB::table('hotel_category')->orderBy('id','desc')->get();
            echo json_encode($data);
        }
    }


    public function edit(Request $request){
       
            $data=DB::table('hotel_category')
                    ->where('id', $request->id)
                    ->get();

             echo json_encode($data);
        }

public function update(Request $request){
   

      $status_msg=array();

  try{
        if($request->ajax())
        {

            $validator=Validator::make($request->all(),[
                'service_charge' => 'required|numeric',
            ]);

        

        if($validator->passes()){

        $data=array();     
        $data['service_charge']=$request->service_charge;
    
     
          $id=DB::table('hotel_category')
              ->where("id",$request->user_id)
              ->update($data);
                $status_msg['msg']=1;
                echo json_encode($status_msg);
          
        } else{
          $status_msg['msg']=2;
          $status_msg['errors']=$validator->errors()->all();
          echo json_encode($status_msg);
        }

      }
    }
    catch(QueryException $e){
      $status_msg['msg']=0;
      $status_msg['errors']=$e->getMessage();
      echo json_encode($status_msg);
    }

    // end of try
}

}
