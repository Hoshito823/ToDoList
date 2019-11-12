<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tasks;

class TasksController extends Controller
{
    public function add () {
        return view('tasks.create');
    }
    
    public function create(Request $request) {
        //Taskモデルの$rulesを使ってフォームから送信されてきたデータのバリデーションを行う
        $this->validate($request, Tasks::$rules);
        
        //モデルからインスタンスを生成
        $task = new Tasks;
        
        //$requestのデータを全て取得
        $form = $request->all();
        
        //画像の保存処理
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $task->image_path = basename($path);
        } else {
            $task->image_path = null;
        }
        
        unset($form['_token']);
        unset($form['image']);
        
        $task->fill($form);
        $task->save();
        
        return redirect('admin/todolist/create');
    } 
}
