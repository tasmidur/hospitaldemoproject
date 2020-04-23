<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;



class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
    $roles=array(
    	"name"=>"Administer",
    	"guard_name"=>"web",
    );

    $model_has_roles=[
    	"model_type"=>"App\User",
    	"model_id"=>1
    ];
  

    $permissions=[
    	"name"=>'Administer roles & permissions',
    	"guard_name"=>'web',
    ];

    $role_has_permissions=[
    	"permission_id"=>1,
    	"role_id"=>1
    ];

    $user=[
    	"name"=>"Administer",
    	"email"=>"admin@admin.com",
      "password"=>"123456",
      "user_access"=>json_encode([
        "access_key"=>"1",
        "access_name"=>"Super-Admin"
      ])
    ];

    User::create($user);
  }
}
