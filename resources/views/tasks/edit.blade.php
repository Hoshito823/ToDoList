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
                
                <div class="form-group row">
                    <label class="col-md-2" for="priority">Priority</label>
                    <div class="col-md-10">
                        <select size=1 name="priority">
                            <option value="">-</option>
                            @for ($i = 0; $i < 5; $i++)
                            <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                            @endfor
                        </select>
                        * Priority Level(1：Highest ~ 5：Lowest)
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
                    <label class="col-md-2" for="detail">Detail</label>
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
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="{{ $task->id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="更新">
                    </div>
                </div>
                        

            </form>
            
          </div>
        </div>
    </div>
@endsection