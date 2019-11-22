@extends('layouts.admin')

@section('title','ToDolist')

@section('content')
    <div class="container">
        <div class="row">
            <h2>ToDolist</h2>
        </div>
        
        <div class="row">
            <div class="col-md-2">
                <a href="{{ action('Admin\TasksController@add') }}" role="button" class="btn btn-primary">
                    Add New Task
                </a>
            </div>
            
            <div class="col-md-2 ">
                <a href="{{ action('Admin\TasksController@display_mytasks') }}" role="button" class="btn btn-primary">
                    Display My Task
                </a>
            </div>
            
            <div class="col-md-8">
                <form action="{{ action('Admin\TasksController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">Title</label>
                        
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title">
                        </div>
                        
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="Search">
                        </div>
                        
                    </div>
                </form>
            </div>

        </div>
        
        <div class="row">
            <div class="list-tasks col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width=10%>ID</th>
                                <th width=20%>Title</th>
                                <th width=60%>Detail</th>
                                <th width="10%">Deadline</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($tasks as $task)
                             @if($task->deadline <> "" && isset($task['deadline']) && $nowTime > $task->deadline)
                                <tr class="bg-danger">
                             @else
                                 <tr>
                             @endif
                                    <th>{{ $task->id }}</th>
                                    <!--<th>{{ $loop->iteration }}</th>-->
                                    <td>{{ \Str::limit($task->title, 100) }}</td>
                                    <td>{{ \Str::limit($task->detail, 250) }}</td>
                                    <td>{{ $task->deadline }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\TasksController@edit', ['id' => $task->id]) }}" class="btn btn-primary">Edit</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\TasksController@delete', ['id' => $task->id]) }}" class="btn btn-primary">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
        
    </div>

@endsection