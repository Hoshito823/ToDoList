@extends('layouts.admin')

@section('title', 'Add Categories')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2 style="margin: 30px 0px">Create New Category</h2>
                
                <form action="{{ action('Admin\CategoriesController@create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    
                    <div class="form-group row">
                        <label class="col-md-2">Category Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    
                    {{ csrf_field() }}
                    
                    <input type="submit" class="btn btn-primary" value="Add">
                </form>
            </div>
        </div>
    </div>
@endsection