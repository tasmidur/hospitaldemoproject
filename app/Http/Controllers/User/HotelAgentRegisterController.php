<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Validator;
use App\hotelagentregister;
use Illuminate\Support\Facades\Auth;

class HotelAgentRegisterController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
    if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 
    return view('Admin-User.hotel-agent-register');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function search(Request $request) {
        if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 

      $status_msg=array();
      if($request->ajax()){
        $search=hotelagentregister::where('hotelname',$request->search_key)
               ->orWhere('hotelname', 'like', '%' . $request->search_key . '%')
               ->orWhere('hotelcontact1', 'like', '%' . $request->search_key . '%')
               ->orWhere('hotelcontact2', 'like', '%' . $request->search_key . '%')
               ->orWhere('hotelowner', 'like', '%' . $request->search_key . '%')
               ->orWhere('hoteltradelicense', 'like', '%' . $request->search_key . '%')
               ->get(); 
        if($search){
        $status_msg['status']=1;   $status_msg['status']=1;
        $status_msg['search_value']=$search;
        echo json_encode($status_msg);
        }
      
      }
     

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 
        $status_msg=array();
        try{
            if($request->ajax()){
            $validator=Validator::make($request->all(),[
                 'hotelowner' => "required|string|max:180",
                 'hotelowneremail' => "required|email|unique:hotelagentregisters,hotelowneremail|max:180",
                 'hotelownercontact' => "required|string|unique:hotelagentregisters,hotelownercontact|max:180",
                 'hotelname' => "required|string|max:180",
                 'hotelemail' => "required|string|unique:hotelagentregisters,hotelemail|max:180",
                 'hotelcontact1' => "required|string|unique:hotelagentregisters,hotelcontact1|max:180",
                 'hotelcontact2' => "required|string|unique:hotelagentregisters,hotelcontact2|max:180",
                 'hoteltradelicense' => "required|string|unique:hotelagentregisters,hoteltradelicense|max:180",
                 'streetaddress' => "required|string|max:180",
                 'city' => "required|string|max:180",
                 'state' => "required|string|max:180",
                 'postcode' => "required|string|max:180",
                 'country' => "required|string|max:180",
                ]);

        if($validator->passes()){

        $data=[
                 'hotelowner' => $request->hotelowner,
                 'hotelowneremail' => $request->hotelowneremail,
                 'hotelownercontact' => $request->hotelownercontact,
                 'hotelname' => $request->hotelname,
                 'hotelemail' => $request->hotelemail,
                 'hotelcontact1' => $request->hotelcontact1,
                 'hotelcontact2' => $request->hotelcontact2,
                 'hoteltradelicense' => $request->hoteltradelicense,
                 'streetaddress' => $request->streetaddress,
                 'city' => $request->city,
                 'state' => $request->state,
                 'postcode' => $request->postcode,
                 'country' => $request->country,
        ];

       
        $hotel = new hotelagentregister($data);
        $hotel->save();
        $status_msg['msg']=1;
        echo json_encode($status_msg);

        }else{
             $status_msg['msg']=2;
             $status_msg['errors']=$validator->errors()->all();
             echo json_encode($status_msg);
            }

            }

        }catch(QueryException $e){
               $status_msg['msg']=0;
               $status_msg['errors']=$e->getMessage();
               echo json_encode($status_msg);
     
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request) {
        if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 
        $status_msg=array();
         if($request->ajax()){
              $data = hotelagentregister::idDescending()->get();
              $status_msg['status']=1;
              $status_msg['hotel']=$data;
              echo json_encode($status_msg);
         }
       
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request) {
        if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 
        $status_msg=array();
        if($request->ajax()){
           $hotel = hotelagentregister::findOrFail($request->id);
           $status_msg['msg']=1;
           $status_msg['edit']=$hotel;
           echo json_encode($status_msg);
        }
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request) {
      // $updateOrder = Order::find($thisOrderID)->update($thisOrder);
      if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
      {
              abort('401');
            
      } 
        $status_msg=array();
        try{
            if($request->ajax()){
            $validator=Validator::make($request->all(),[
                'hotelowner' => "required|string|max:180",
                'hotelowneremail' => "required|email|max:180|unique:hotelagentregisters,hotelowneremail, ".$request->id,
                'hotelownercontact' => "required|string||max:180|unique:hotelagentregisters,hotelownercontact, ".$request->id,
                'hotelname' => "required|string|max:180",
                'hotelemail' => "required|string|max:180|unique:hotelagentregisters,hotelemail, ".$request->id,
                'hotelcontact1' => "required|string|max:180|unique:hotelagentregisters,hotelcontact1, ".$request->id,
                'hotelcontact2' => "required|string|max:180|unique:hotelagentregisters,hotelcontact2, ".$request->id,
                'hoteltradelicense' => "required|string|max:180|unique:hotelagentregisters,hoteltradelicense, ".$request->id,
                'streetaddress' => "required|string|max:180",
                'city' => "required|string|max:180",
                'state' => "required|string|max:180",
                'postcode' => "required|string|max:180",
                'country' => "required|string|max:180",
                ]);

        if($validator->passes()){

        $data=[
                 'hotelowner' => $request->hotelowner,
                 'hotelowneremail' => $request->hotelowneremail,
                 'hotelownercontact' => $request->hotelownercontact,
                 'hotelname' => $request->hotelname,
                 'hotelemail' => $request->hotelemail,
                 'hotelcontact1' => $request->hotelcontact1,
                 'hotelcontact2' => $request->hotelcontact2,
                 'hoteltradelicense' => $request->hoteltradelicense,
                 'streetaddress' => $request->streetaddress,
                 'city' => $request->city,
                 'state' => $request->state,
                 'postcode' => $request->postcode,
                 'country' => $request->country,
        ];

       
        $hotel = hotelagentregister::find($request->id)->update($data);
     
        $status_msg['msg']=1;
        echo json_encode($status_msg);

        }else{
             $status_msg['msg']=2;
             $status_msg['errors']=$validator->errors()->all();
             echo json_encode($status_msg);
            }

            }

        }catch(QueryException $e){
               $status_msg['msg']=0;
               $status_msg['errors']=$e->getMessage();
               echo json_encode($status_msg);
     
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request) {
        if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 
        $status_msg=array();
        if($request->ajax()){
            $hotel = hotelagentregister::findOrFail($request->id);
            $hotel->delete();
            $status_msg["msg"]=1;
            echo json_encode($status_msg);
        }
}
}
