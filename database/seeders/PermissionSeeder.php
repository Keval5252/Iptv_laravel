<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission as ContractsPermission;
use Spatie\Permission\Models\Permission;
use Log;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['name'=>'dashboard','guard_name'=>'web'],
            ['name'=>'acl-user-list','guard_name'=>'web'],
            ['name'=>'acl-user-create','guard_name'=>'web'],
            ['name'=>'acl-user-edit','guard_name'=>'web'],
            ['name'=>'acl-user-delete','guard_name'=>'web'],
            ['name'=>'acl-role-list','guard_name'=>'web'],
            ['name'=>'acl-role-create','guard_name'=>'web'],
            ['name'=>'acl-role-edit','guard_name'=>'web'],
            ['name'=>'acl-role-delete','guard_name'=>'web'],
            ['name'=>'permission-list','guard_name'=>'web'],
            ['name'=>'permission-create','guard_name'=>'web'],
            ['name'=>'permission-edit','guard_name'=>'web'],
            ['name'=>'permission-delete','guard_name'=>'web'],
            ['name'=>'pages-list','guard_name'=>'web'],
            ['name'=>'pages-create','guard_name'=>'web'],
            ['name'=>'pages-edit','guard_name'=>'web'],
            ['name'=>'pages-delete','guard_name'=>'web'],
            ['name'=>'users-list','guard_name'=>'web'],
            ['name'=>'users-create','guard_name'=>'web'],
            ['name'=>'users-edit','guard_name'=>'web'],
            ['name'=>'users-status','guard_name'=>'web'],
            ['name'=>'version-view','guard_name'=>'web'],
            ['name'=>'version-update','guard_name'=>'web'],
            ['name'=>'setting-view','guard_name'=>'web'],
            ['name'=>'setting-update','guard_name'=>'web'],
        ];
        Permission::insert($data);         
    }
}
