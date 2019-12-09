<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
//ログイン情報を取得するための記述
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Task;
use App\Category;
use App\TaskTag;
use App\Tag;
//日付操作ライブラリ使用
use Carbon\Carbon;
class TasksController extends Controller
{
    //Return task add page
    public function add () {
        $categories = Category::get();
        $tags = Tag::get();
        return view('tasks.create', compact('categories', 'tags'));
    }
    
    
    //Create New Task
    public function create (Request $request) {
        
        //Taskモデルの$rulesを使ってフォームから送信されてきたデータのバリデーションを行う
        $this->validate($request, Task::$rules);
        
        //モデルからインスタンスを生成
        $task = new Task;
        
        //ログインユーザー情報を取得
        $user = Auth::user();
        
        //$requestのデータを全て取得
        $form = $request->all();
        
        
        //画像の保存処理
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $task->image_path = basename($path);
        } else {
            $task->image_path = null;
        }
        
        $task->user_id = $user->id;
        
        unset($form['_token']);
        unset($form['image']);
        
        $task->fill($form);
        $task->save();
        
        //formから送られてくるtagsが存在しない時はpassする処理を記述
        if (isset($form['tags'])) {
            $task->tags()->sync($form['tags']); 
        }
        
        return redirect('todolist');
    } 
    
    
    // Display Task
    public function index (Request $request) {
        
        //condition title （検索キー）という意味？
        $cond_title = $request->cond_title;
        
        if ($cond_title != '') {
            //find cond_title from Task model and return all records which have cond_title in 'title' field.
            $tasks = Task::where('title',$cond_title)->get();
        } else {
            //get all records from Task model. you will pass this brunch when you access first.
            $tasks = Task::all();
        }
        
        //get now time
        $nowTime = Carbon::now();
        $nowTime = $nowTime->format('Y-m-d');
        
        return view('tasks.index', compact('tasks', 'cond_title', 'nowTime'));
        // return view('tasks.index',['tasks' => $tasks, 'cond_title' => $cond_title, 'nowTime' => $nowTime]);
    }
    
    //Edit exiting task
    public function edit (Request $request) {
        $task = Task::find($request->id);
        if (empty($task)) {
            abort(404);
        }
        $tags = Tag::get();
        $categories = Category::get();
        return view('tasks.edit', compact('task', 'tags', 'categories'));
    }
    
    //update task
    public function update(Request $request) {
        //validationをかける
        $this->validate($request,Task::$rules);
        $task = Task::find($request->id);
        
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
        
        return redirect('todolist');
        
    }
    
    public function delete(Request $request){
        $task = Task::find($request->id);
        $task->delete();
        return redirect('todolist');
    }
    
    public function complete(Request $request){
        $task = Task::find($request->id);
        $task->complete = 1;
        $task->priority = Null;
        $task->save();
        return redirect('todolist/mytasks');
    }
    
    public function display_mytasks(Request $request) {
        //ユーザー情報を取得
        $user = Auth::user();
        
        //カテゴリ情報を取得
        $categories = Category::get();
        
        //カテゴリが指定されたら、そのカテゴリだけのタスクを見つける
        $category_key = $request->category_key;
        
        if ($category_key != '') {
            //現在ログインしているユーザーのタスク、未完了、優先度が設定されている、優先度順位に照準ソート
            $tasks = Task::where('user_id',$user->id)
                    ->where('complete', 0)
                    ->WhereNotNull('priority')
                    ->where('category_id', $category_key)
                    ->orderBy('priority', 'asc')
                    ->get();
        
            //現在ログインしているユーザーのタスク、未完了、優先度が設定されていないタスクを取得
            $priority_undefinded_Task = Task::where('user_id',$user->id)
                                        ->where('complete',0)
                                        ->whereNull('priority')
                                        ->where('category_id', $category_key)
                                        ->get();
            
        } else {
            //現在ログインしているユーザーのタスク、未完了、優先度が設定されている、優先度順位に照準ソート
            $tasks = Task::where('user_id',$user->id)
                    ->where('complete', 0)
                    ->WhereNotNull('priority')
                    ->orderBy('priority', 'asc')
                    ->get();
        
            //現在ログインしているユーザーのタスク、未完了、優先度が設定されていないタスクを取得
            $priority_undefinded_Task = Task::where('user_id',$user->id)
                                        ->where('complete',0)
                                        ->whereNull('priority')
                                        ->get();
        }
        
                            
        
        //別々に取得したデータを結合して$tasksに代入する
        $tasks = $tasks->concat($priority_undefinded_Task);
        
        $nowTime = Carbon::now();
        $nowTime = $nowTime->format('Y-m-d');
        
        //結合済みの$tasksを返す場合
        return view('tasks.mytasks', compact('tasks', 'nowTime', 'categories'));
        // return view('tasks.mytasks', ['tasks' => $tasks, 'nowTime' => $nowTime]);
        
        
        
        // $conditions = [
        //     'user_id' => $user->id,
        //     'complete' => 0
        // ];    
        
        
        // $tasks = Task::where(function ($query) use ($conditions) {
        //     foreach ($conditions as $key => $value) {
        //         $query->where($key, $value);
        //     }
        // })
        // ->get();
        
        //結合していない優先順位を持つtasks、持たないtasksを別々に持つ場合
        // return view('tasks.mytasks', ['tasks' => $tasks, 'nowTime' => $nowTime, 'priority_undefinded_Task' => $priority_undefinded_Task]);
    }
    
    
    public function display_done_mytasks(Request $request) {
        
        $user = Auth::user();
        
        //現在のユーザーIDに紐づいたTaskを返す。かつ完了済み（complete=１)のもの
        $tasks = Task::where('user_id',$user->id)->where('complete', 1)->get();
        
        return view('tasks.donemytasks', ['donetasks' => $tasks]);
    }
    
    
    // public function add_priority(Request $request){
    //     $user = Auth::user();
    //     $task = Task::where('user_id', $user->id)->where('complete',0)->get();
        
    //     //優先度設定
    //     $task->priority = $request->priority;
    //     $task->save();
        
    //     //現在時刻取得
    //     $nowTime = Carbon::now();
        
    //     //タスク内容全取得
    //     $tasks = Task::where('user_id', $user->id)->where('complete', 0)->get();
        
    //     return view('tasks.mytasks', ['tasks' => $tasks, 'nowTime' => $nowTime]);
        
    // }
}