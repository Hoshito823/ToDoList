@extends('layouts.admin')
@section('title', 'Create New Task')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>Create New Task</h2>
                
                <form action="{{ action('Admin\TasksController@create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    
                    <!--SetTasksFunction-->
                    <div class="form-group row">
                        <label class="col-md-2">Priority</label>
                        <span class="col-md-5">*Level(1：Highest ~ 5：Lowest)</span>
                        <div class="col-md-2 offset-3">
                            <select class="custom-select" size=1 name="priority">
                                <option value="">-</option>
                                @for ($i = 0; $i < 5; $i++)
                                <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">Category</label>
                        <div class="col-md-10">
                            <select class="custom-select" size=1 name="category_id">
                                <option value="">-</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">Dead Line</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="deadline" value="<?php echo date('Y-m-d');?>">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">Task Title</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">Task Detail</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="detail" rows="20">{{ old('detail') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">Image</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">Tags</label>
                        <div class="col-md-10">
                        @foreach($tags as $tag)
                            <div class="custom-control custom-checkbox col-md-10">
                              <input type="checkbox" class="custom-control-input" id="{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
                              <label class="custom-control-label" for="{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    
                    {{ csrf_field() }}
                    
                    <input type="submit" class="btn btn-primary" value="Add">
                </form>
            </div>
        </div>
    </div>
@endsection