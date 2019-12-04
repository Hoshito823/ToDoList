<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //自動採番なので他の値が入らないようにする
    protected $guarded = array('id');
    
    //$rulesという名前で連想配列を作成する
    public static $rules = array(
      'title' => 'required',
      'detail'=> 'required',
    );
    
    public function category()
    {
      return $this->hasOne('App\Category');
    }
    
    public function getTasksByCategory(){
      //
    }
    
    
}
