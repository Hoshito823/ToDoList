<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

//ログイン情報を取得するための記述
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Tasks;

//日付操作ライブラリ使用
use Carbon\Carbon;

class TasksController extends Controller
{
    //Return task add page
    public function add () {
        return view('tasks.create');
    }
    
    
    //Create New Task
    public function create (Request $request) {
    
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
        
        //ログインユーザー情報を取得
        $user = Auth::user();
        $task->user_id = $user->id;
        
        $task->fill($form);
        $task->save();
        
        return redirect('admin/todolist');
    } 
    
    
    // Display Tasks
    public function index (Request $request) {
        
        //condition title （検索キー）という意味？
        $cond_title = $request->cond_title;
        
        if ($cond_title != '') {
            //find cond_title from Tasks model and return all records which have cond_title in 'title' field.
            $tasks = Tasks::where('title',$cond_title)->get();
        } else {
            //get all records from Tasks model. you will pass this brunch when you access first.
            $tasks = Tasks::all();
        }
        
        //get now time
        $nowTime = Carbon::now();
        $nowTime = $nowTime->format('Y-m-d');
        
        return view('tasks.index',['tasks' => $tasks, 'cond_title' => $cond_title, 'nowTime' => $nowTime]);
    }
    
    //Edit exiting task
    public function edit (Request $request) {
        $task = Tasks::find($request->id);
        if (empty($task)) {
            abort(404);
        }
        return view('tasks.edit',['task' => $task]);
    }
    
    //update task
    public function update(Request $request) {
        //validationをかける
        $this->validate($request,Tasks::$rules);
        $task = Tasks::find($request->id);
        
        $task_form = $request->all();
        
        if (isset($task_form['image'])) {
            $path = $request->file('image')->store('public/image');
            $task->image_path = basename($path);
            unset($task_form['image']);
        } elseif (isset($request->remove)) {
            $task->image_path = null;
            unset($task_form['image']);
        }
        
        unset($request['_token']);
        
        //ユーザー情報と紐づけ
        $user = Auth::user();
        $task->user_id = $user->id;
        
        $task->fill($task_form)->save();
        
        return redirect('admin/todolist');
        
    }
    
    public function delete(Request $request){
        $task = Tasks::find($request->id);
        $task->delete();
        return redirect('admin/todolist');
    }
    
    public function complete(Request $request){
        $task = Tasks::find($request->id);
        $task->complete = 1;
        $task->save();
        return redirect('admin/todolist/mytasks');
    }
    
    public function display_mytasks(Request $request) {
        //ユーザー情報を取得
        $user = Auth::user();
    
        //現在のユーザーIDに紐づいたTaskを返す。かつ未完了（comoplete=0)のもの
        $tasks = Tasks::where('user_id',$user->id)->where('complete', 0)->get();

        return view('tasks.mytasks', ['tasks' => $tasks]);
    }
    
    public function display_done_mytasks(Request $request) {
        
        $user = Auth::user();
        
        //現在のユーザーIDに紐づいたTaskを返す。かつ完了済み（comoplete=１)のもの
        $tasks = Tasks::where('user_id',$user->id)->where('complete', 1)->get();
        
        return view('tasks.donemytasks', ['donetasks' => $tasks]);
    }
    
    
    
    
}
