<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class defaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superuser = User::where("email", "superadmin@grr.la")->first();
        $user = User::where("email", "admin@admin.com")->first();
        if (!$superuser) {
            $superuser = new User();
            $superuser->email  = "superadmin@grr.la";
            $superuser->name = "SuperAdmin";
            $superuser->user_name = "SuperAdmin";
            $superuser->photo = "images.png";
            $superuser->password = bcrypt('123456789');
            $superuser->gender = 1;
            $superuser->user_type = 1;
            $superuser->save();
        }
        if (!$user) {
            $user = new User();
            $user->email  = "admin@admin.com";
            $user->name = "Admin";
            $user->user_name = "admin";
            $user->photo = "images.png";
            $user->password = bcrypt('123456789');
            $user->gender = 1;
            $user->user_type = 1;
            $user->save();
        }

        
        $role = Role::create(['name' => 'SuperAdmin']);
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'User']);
        $superuser->assignRole([$role->id]);
        $user->assignRole([$role1->id]);
    }
}