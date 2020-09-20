<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
class UsersController extends Controller
{
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
    public function getUsers(){
        $users = User::orderBy('id','Desc')->get();
        $data = ['users'=>$users];
        return view('admin.users.home', $data);
        
    }
}
