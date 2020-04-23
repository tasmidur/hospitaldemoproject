<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vehicleagentregister;
use Illuminate\Database\QueryException;
use Validator;
use Illuminate\Support\Facades\Auth;

class VehicleAgentRegisterController extends Controller
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
        return view('Admin-User.vehicle-agent-register');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
        //Get all roles
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
                  "vehicleagency_name" => "required|string|max:180",
                  "email" => "required|string|unique:vehicleagentregisters,email|max:180",
                  "contact" => "required|string|unique:vehicleagentregisters,contact|max:180",
                  "contact1" => "required|string|unique:vehicleagentregisters,contact1|max:180",
                  "tradelicense" => "required|string|unique:vehicleagentregisters,tradelicense|max:180",
                  "streetaddress" => "required|string|max:180",
                  "city" => "required|string|max:180",
                  "state" => "required|string|max:180",
                  "postcode" => "required|string|max:180",
                  "country" => "required|string|max:180",
                ]);

        if($validator->passes()){

          $data=[
                 "vehicleagency_name" => $request->vehicleagency_name,
                  "email" => $request->email,
                  "contact" => $request->contact,
                  "contact1" => $request->contact1,
                  "tradelicense" => $request->tradelicense,
                  "streetaddress" => $request->streetaddress,
                  "city" => $request->city,
                  "state" => $request->state,
                  "postcode" => $request->postcode,
                  "country" => $request->country,
          ];

        $vehicle=vehicleagentregister::insert($data);
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
              $vehicle = vehicleagentregister::idDescending()->get();
              $status_msg['status']=1;
              $status_msg['vehicle']=$vehicle;
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
           $vehicle = vehicleagentregister::findOrFail($request->id);
           $status_msg['msg']=1;
           $status_msg['edit']=$vehicle;
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
        if (!Auth::user()->hasPermissionTo('Administer-roles-permissions'))
        {
                abort('401');
              
        } 
        $status_msg=array();
        try{
            if($request->ajax()){
            $validator=Validator::make($request->all(),[
                "vehicleagency_name" => "required|string|max:180",
                "email" => "required|string|max:180|unique:vehicleagentregisters,email,".$request->id,
                "contact" => "required|string|max:180|unique:vehicleagentregisters,contact,".$request->id,
                "contact1" => "required|string|max:180|unique:vehicleagentregisters,contact1,".$request->id,
                "tradelicense" => "required|string|max:180|unique:vehicleagentregisters,tradelicense,".$request->id,
                "streetaddress" => "required|string|max:180",
                "city" => "required|string|max:180",
                "state" => "required|string|max:180",
                "postcode" => "required|string|max:180",
                "country" => "required|string|max:180",
                ]);

        if($validator->passes()){

          $data=[
                 "vehicleagency_name" => $request->vehicleagency_name,
                  "email" => $request->email,
                  "contact" => $request->contact,
                  "contact1" => $request->contact1,
                  "tradelicense" => $request->tradelicense,
                  "streetaddress" => $request->streetaddress,
                  "city" => $request->city,
                  "state" => $request->state,
                  "postcode" => $request->postcode,
                  "country" => $request->country,
          ];

        $vehicle=vehicleagentregister::find($request->id)->update($data);
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
            $vehicle = vehicleagentregister::findOrFail($request->id);
            $vehicle->delete();
            $status_msg["msg"]=1;
            echo json_encode($status_msg);
    }
}
}
