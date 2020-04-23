<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Database\QueryException;
use Validator;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;


class PermissionController extends Controller
{
//    public function __construct() {
//         $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
//     }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        return view('Admin-User.permission');
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
        $status_msg=array();
        try{
            if($request->ajax()){
            $validator=Validator::make($request->all(),[
                'name'=>'required|max:100|unique:permissions,name',
                ]);

        if($validator->passes()){

        $name = $request->name;
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request->roles;

        $permission->save();

        if (!empty($request->roles)) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }
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
        $status_msg=array();
         if($request->ajax()){
              $permissions = Permission::idDescending()->get();
              $roles = Role::get();
              $status_msg['status']=1;
              $status_msg['permission']=$permissions;
              $status_msg["role"]=$roles;

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
        $status_msg=array();
        if($request->ajax()){
           $permission = Permission::findOrFail($request->id);
           $status_msg['msg']=1;
           $status_msg['edit']=$permission;
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
        $status_msg=array();
        try{

            if($request->ajax()){
                $validator=Validator::make($request->all(), [
                    'name'=>'required|max:100|unique:permissions,name,'.$request->id,
              ]);

                if($validator->passes()){
                    
                     $permission = Permission::findOrFail($request->id);
                     $input = $request->all();
                     $permission->fill($input)->save();

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
        $status_msg=array();
        if($request->ajax()){
            $permission = Permission::findOrFail($request->id);

    //Make it impossible to delete this specific permission    
    if ($permission->name == "Administer-roles-permissions") {
            $status_msg["msg"]=0;
            $status_msg["errors"]='Cannot delete this Permission!';
            echo json_encode($status_msg);

        }
    else{
        $permission->delete();
        $status_msg["msg"]=1;
        echo json_encode($status_msg);
 
    }
    }
}
}
