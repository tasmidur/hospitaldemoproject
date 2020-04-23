<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Mail;
use App\Mail\UserRegistermail;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\hotelagentregister;
use App\vehicleagentregister;
use Illuminate\Database\QueryException;

use Validator;
use App\Jobs\UserRegistermailjob;
use Carbon\Carbon;


class UserController extends Controller
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
    //Get all users and pass it to the view
      
        return view('Admin-User.user');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
    //Get all roles and pass it to the view
        $roles = Role::get();
        return view('users.create', ['roles'=>$roles]);
    }


    public function agent(Request $request){
        $status_msg=array();
        if($request->ajax()){
            
            if($request->agent_id==3){
               $status_msg['agent_name']=vehicleagentregister::all();
               $status_msg['status']=1;
               echo json_encode($status_msg);
            }else{
                $status_msg['agent_name']=hotelagentregister::all();
                $status_msg['status']=1;
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
        $status_msg=array();

        try{

            if($request->ajax()){

                $validator=Validator::make($request->all(), [
                    'name'=>'required|max:120',
                    'email'=>'required|email|unique:users,email',
                    'password'=>'required|min:6|confirmed',
                    "agent_name"=>'required|string',
                    "access_key"=>"required|numeric"
                ]);
                if($validator->passes()){
                    $data=[
                        "name"=>$request->name,
                        "email"=>$request->email,
                        "password"=>$request->password,
                        "user_access"=>json_encode([
                            "access_key"=>$request->access_key,
                            "access_name"=>$request->agent_name
                        ])
                    ];

                    $user = User::create($data); //Retrieving only the email and password data

                    $roles = $request['roles']; //Retrieving the roles field
                //Checking if a role was selected
                    if (isset($roles)) {
            
                        foreach ($roles as $role) {
                        $role_r = Role::where('id', '=', $role)->firstOrFail();            
                        $user->assignRole($role_r); //Assigning role to user
                        }
                    }
                    
                    $data['flag']=1;

                    $emailJob = new UserRegistermailjob($data);    
                    dispatch($emailJob)->delay(Carbon::now()->addSeconds(20));

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

              $users = User::idDescending()->get();
              $roles = Role::idDescending()->get();
              $status_msg['status']=1;
              $status_msg["role"]=$roles;

              $table="<tr>";

              foreach ($users as $user) {
                 $table.="<td>".$user->name."</td>";
                 $table.="<td>".$user->email."</td>";
                 $table.="<td>".($user->roles()->pluck('name')->implode(' '))."</td>";
                 $action="<button class='btn btn-info btn-sm update' id='".$user->id."'>Edit</button>";
                 $action.="  <button class='btn btn-danger btn-sm delete' id='".$user->id."'>Delete</button><br><br>";
                 $action.="  <button class='btn btn-success btn-sm is_active' id='".$user->id."'>Active</button>";
                 $table.="<td>".$action."</td></tr>";
              }

              $status_msg['user']=$table;
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
            $user = User::findOrFail($request->id); //Get user with specified id
         
            $status_msg['msg']=1;
            $status_msg["user"]=$user;
         
            $permit_id=json_decode($user->roles()->pluck('role_id'));

            // echo json_encode($permit_id);

            $p_all = Role::all();
            $check="";
            foreach ($p_all as $p) {
              if(in_array($p->id,$permit_id)){
                $check.='<input type="checkbox" class="filled-in" id="ig_checkbox'.$p->id.'" name="roles[]" value="'.$p->id.'" checked> <label for="ig_checkbox'.$p->id.'">'.$p->name.'</label>';
              }
              else{
                 $check.='<input type="checkbox" class="filled-in" id="ig_checkbox'.$p->id.'" name="roles[]" value="'.$p->id.'"> <label for="ig_checkbox'.$p->id.'">'.$p->name.'</label>';
              }
            }
            $status_msg['role']=$check;
            
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
                    'name'=>'required|max:120',
                    'email'=>'required|email|unique:users,email,'.$request->id,
                    'password'=>'required|min:6|confirmed',
                    "agent_name"=>'required|string',
                    "access_key"=>"required|numeric"
                ]);
                if($validator->passes()){
                    $data=[
                        "name"=>$request->name,
                        "email"=>$request->email,
                        "password"=>$request->password,
                        "user_access"=>json_encode([
                            "access_key"=>$request->access_key,
                            "access_name"=>$request->agent_name
                        ])
                    ];

                    $user = User::findOrFail($request->id); //Get role specified by id

                    $roles = $request['roles']; //Retreive all roles
                    $user->fill($data)->save();

                    if (isset($roles)) {        
                     $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
                    }        
                    else {
                    $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
                    }

                    $data['flag']=2;

                    $emailJob = new UserRegistermailjob($data);    
                    dispatch($emailJob)->delay(Carbon::now()->addSeconds(20));

                    // $mail=new UserRegistermail($data);
                    // Mail::to($data['email'])->send($mail);
                    
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
    //Find a user with a given id and delete
    $status_msg=array();
    if($request->ajax()){
        $user = User::findOrFail($request->id); 
        $user->delete();
        $status_msg['msg']=1;
        echo json_encode($status_msg);
    }
       
    }
}
