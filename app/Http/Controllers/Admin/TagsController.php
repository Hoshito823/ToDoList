<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Controllers\Controllers;

use App\Task;

use App\Tag;


class TagsController extends Controller
{
    public function add() {
        return view('tags.create');
    }
    
    public function create(Request $request) {
        $this->validate($request, Tag::$rules);
        
        $form = $request->all();
    
        unset($form['_token']);
        
        $tag = new Tag;
        
        //フォームから送られてきた値をTagモデルに挿入
        $tag->fill($form);
        $tag->save();
        
        return redirect('todolist');
    }
    
}
