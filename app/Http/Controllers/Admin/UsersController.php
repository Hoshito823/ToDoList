<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

//ログイン情報を取得するための記述
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Tasks;

class UsersController extends Controller
{
    public function add() {
        return('admin.users.create'); 
    }
    
    public function display_mytasks(Request $request) {
        //ユーザー情報を取得
        $user = Auth::user();
    
        //現在のユーザーIDに紐づいたTaskを返す
        $tasks = Tasks::where('user_id',$user->id)->get();
    
        // //ユーザーに紐づくタスク情報を全取得
        // $tasks = $users->tasks();
    
        // //やたらいろんな情報が取れている
        // dd($tasks);
        
        return view('tasks.mytasks', ['tasks' => $tasks]);
    }
    
    
}
