<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Mentor;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request; 

class DashboardControler extends Controller
{
    public function getData(){

        $data['total_users']=User::count();
        $data['mentors']=Mentor::count();
         $data['role_models']=RoleModel::count();
        $data['blogs']=Blog::count();
        $data['users']=User::take(10)->get();
        return response()->json($data,200);
    }
}
