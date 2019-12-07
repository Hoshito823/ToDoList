<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //自動採番なので他の値が入らないようにする
    protected $guarded = ['id', 'tags'];
    
    //$rulesという名前で連想配列を作成する
    public static $rules = array(
      'title' => 'required',
      'detail'=> 'required',
    );
    
    public function category()
    {
      return $this->belongsTo('App\Category');
    }
    
    public function tags()
    {
      return $this->belongsToMany('App\Tag', 'task_tags');
    }
    
    public function getTasksByCategory(){
      
    }
    
    
}
