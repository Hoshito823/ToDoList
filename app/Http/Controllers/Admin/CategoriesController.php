<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//ログイン情報を取得するための記述
use Illuminate\Support\Facades\Auth;

use App\Task;
use App\Category;

class CategoriesController extends Controller
{
    public function add() {
        return view('categories.create');
    }
    
    public function create(Request $request) {
        $this->validate($request, Category::$rules);
        $form = $request->all();
        $category = new Category;
        
        unset($form['_token']);
        
        $category->fill($form);
        $category->save();
        
        return redirect('todolist');
    }
    
    
    //CategoriesControllerからviewを返そうかと考えていたが、display_mytasksから返すことにした
    // public function displayByCategories(Request $request) {
        
    //     $user = Auth::user();
    //     $tasks = Tasks::where('user_id', $user->id)
    //                 ->where('complete', 0)
    //                 ->where('category_id', $request->category_id)
    //                 ->get();
                    
    //     return view('tasks.mytasks', ['tasks' => $tasks]);
    // }
        
}
