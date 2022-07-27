<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Mentor;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getData(){
        $data['total_user']=User::count();
        $data['total_mentor']=Mentor::count();
        $data['total_blog']=Blog::count();
        $data['total_role_model']=RoleModel::count();
        $data['recent_user']=User::latest()->paginate(10);

        return response()->json($data,200);

    }
}
