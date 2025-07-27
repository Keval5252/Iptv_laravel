<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB,Auth;

class AdminController extends Controller
{


    public function index()
    {
        
        $data = (object) [];
        $data->total_users = User::whereHas('roles', function($q){
            $q->whereIn('name', ['user']);
        })->count();
        // $data->total_users = User::count();

        return view('admin.home')->with("data", $data);
    }
}
