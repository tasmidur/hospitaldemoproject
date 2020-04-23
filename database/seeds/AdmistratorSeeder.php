<?php

use Illuminate\Database\Seeder;
use App\User;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class AdmistratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permission = new Permission();
        $permission->name = "Administer-roles-permissions";
        $permission->save();

        $role = new Role();
        $role->name = "Super-Admin";
        $role->save();

        $p = Permission::where('name', '=',"Administer-roles-permissions")->firstOrFail(); 
        $role = Role::where('name', '=',"Super-Admin")->first(); 
        $role->givePermissionTo($p);
      
        $user=[
            "name"=>"Administer",
            "email"=>"admin@admin.com",
            "password"=>"123456",
            "user_access"=>json_encode([
            "access_key"=>"1",
            "access_name"=>"Super-Admin"
          ]),
            "status"=>1
        ];
    
        $user = User::create($user);
        $role_r = Role::where('id', '=', $role)->firstOrFail();            
        $user->assignRole($role_r); //Assigning role to user
    }
}
