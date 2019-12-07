@extends('layouts.admin')

@section('title','Task Edit Page')

@section('content')
    <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <h2>Task Edit Page</h2>
            
            <form action="{{ action('Admin\TasksController@update') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                    <ul>
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                @endif
                
                <!-- 作成時に選択されていたオプションを選択済みにする -->
                <div class="form-group row">
                    <label class="col-md-2">Priority</label>
                    <span class="col-md-5">*Level(1：Highest ~ 5：Lowest)</span>
                    <div class="col-md-2 offset-3">
                        <select class="custom-select" size=1 name="priority">
                            <option value="">-</option>
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i == $task->category_id)
                                    <option selected value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                                @else
                                    <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                </div>
                
                <!-- 作成時に選択されていたオプションを選択済みにする -->
                <div class="form-group row">
                    <label class="col-md-2">Category</label>
                    <div class="col-md-10">
                        <select class="custom-select" size=1 name="category_id">
                            <option value="">-</option>
                            @foreach ($categories as $category)
                                @if ($category->id == $task->category_id)
                                    <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2" for="deadline">Deadline</label>
                    <div class="col-md-10">
                        <input type="date" class="form-control" name="deadline" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div> 
                
                <div class="form-group row">
                    <label class="col-md-2" for="title">Title</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ $task->title }}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2" for="detail">Task Detail</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="detail" rows="20">{{ $task->detail }}</textarea>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2" for="image">Image</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="image">
                        <div class="form-text text-info">
                            設定中：{{ $task->image_path }}
                        </div>
                        
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="remove">画像を削除
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2">Tags</label>
                    <div class="col-md-10">
                    @foreach($tags as $tag)
                        <div class="custom-control custom-checkbox col-md-10">
                          @php
                          if ($task->tags->search(function ($item, $key) use ($tag) {
                              return $item->id == $tag->id;
                          })) {
                              $checked = "checked='checked'";
                          } else {
                              $checked = "";
                          }
                          @endphp
                          
                          <input type="checkbox" class="custom-control-input" {{ $checked }} id="{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
                          <label class="custom-control-label" for="{{ $tag->id }}">{{ $tag->name }}</label>
                         
                        </div>
                    @endforeach
                    </div>
                </div>
                
                        
                <div class="form-group row">
                    <div class="col-md-2">
                        <input type="hidden" name="id" value="{{ $task->id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </div>
                        
            </form>
            
          </div>
        </div>
    </div>
@endsection