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
    
    
}
