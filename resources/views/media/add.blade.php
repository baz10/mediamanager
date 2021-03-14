@extends('adminlte::page')

@section('title', 'Add Media')

@section('content_header')
    <h1>Add Media</h1>
@stop

@section('content')

<div class="container mt-2">
  
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('media.index') }}"> Back</a>
        </div>
    </div>
</div>
   
  @if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
  @endif
   
<form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Media Title:</strong>
                <input type="text" name="title" class="form-control" placeholder="Media Title">
               @error('title')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
               @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Media Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Media Description"></textarea>
                @error('description')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Media Image:</strong>
                 <input type="file" name="media_file" class="form-control" placeholder="Media Title">
                @error('image')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
               @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category Type:</strong>
                <select class="form-select" aria-label="Select Category" name="category_id">
                <option selected>Select Category</option>
                @foreach ($category as $c)

                <option value="{{ $c->category_id }}">{{ $c->category_name }}</option>

                @endforeach

              </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary ml-3">Submit</button>
    </div>
   
</form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop