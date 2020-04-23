<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

use Illuminate\Database\QueryException;
use Validator;


class RoleController extends Controller
{
//    public function __construct() {
//         $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
//     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('Admin-User.role');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::all();//Get all permissions

        return view('roles.create', ['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    //Validate name and permissions field
        $status_msg=array();
        try{

            if($request->ajax()){
                $validator=Validator::make($request->all(), [
                       'name'=>'required|unique:roles,name|max:100',
                       'permissions' =>'required',
                       ]
                );

                if($validator->passes()){

                    $name = $request->name;
                    $role = new Role();
                    $role->name = $name;

                    $permissions = $request->permissions;

                    $role->save();
                    //Looping thru selected permissions
                    foreach ($permissions as $permission) {
                        $p = Permission::where('id', '=', $permission)->firstOrFail(); 
                       //Fetch the newly created role and assign permission
                        $role = Role::where('name', '=', $name)->first(); 
                        $role->givePermissionTo($p);
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
              $roles = Role::all();
              $permissions = Permission::idDescending()->get();
              $status_msg['status']=1;
              $status_msg["permission"]=$permissions;

              $table="<tr>";

              foreach ($roles as $role) {
                 $table.="<td>".$role->name."</td>";
                 $table.="<td>".(str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')))."</td>";
                 $action="<button class='btn btn-info btn-sm update' id='".$role->id."'>Edit</button>";
                  $action.="   <button class='btn btn-danger btn-sm delete' id='".$role->id."'>Delete</button>";
                  $table.="<td>".$action."</td></tr>";
              }

              $status_msg['role']=$table;
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

            $role = Role::findOrFail($request->id);
            $status_msg['msg']=1;
            $status_msg["role"]=$role;
            $permit_id=json_decode($role->permissions()->pluck('permission_id'));

            // echo json_encode($permit_id);

            $p_all = Permission::all();
            $check="";
            foreach ($p_all as $p) {
              if(in_array($p->id,$permit_id)){
                $check.=' <li class="d-inline-block mr-3"><input type="checkbox" class="custom-control-input" id="ig_checkbox'.$p->id.'" name="permissions[]" value="'.$p->id.'" checked> <label class="custom-control-label" for="ig_checkbox'.$p->id.'">'.$p->name.'</label></li>';
               
            }
              else{
                $check.=' <li class="d-inline-block mr-3"><input type="checkbox" class="custom-control-input" id="ig_checkbox'.$p->id.'" name="permissions[]" value="'.$p->id.'"> <label class="custom-control-label" for="ig_checkbox'.$p->id.'">'.$p->name.'</label></li>';;
              }
            }
            
            $status_msg["permission"]=$check;

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
                'name'=>'required|max:100|unique:roles,name,'.$request->id,
                'permissions' =>'required',
                ]); 
                if($validator->passes()){


                    $role = Role::findOrFail($request->id);
                    $input = $request->except(['permissions']);
                    $permissions = $request['permissions'];
                    $role->fill($input)->save();

                    $p_all = Permission::all();//Get all permissions

                    foreach ($p_all as $p) {
                    $role->revokePermissionTo($p); //Remove all permissions associated with role
                    }

                    foreach ($permissions as $permission) {
                    $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
                    $role->givePermissionTo($p);  //Assign permission to role
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $status_msg=array();
        if($request->ajax()){
         $role = Role::findOrFail($request->id);
         $role->delete();
         $status_msg['msg']=1;
         echo json_encode($status_msg);
        }

    }
}
