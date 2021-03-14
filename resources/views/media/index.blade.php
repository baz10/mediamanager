@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

<div class="container mt-2">
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Media Manager</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('media.create') }}"> Add New Media</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($media as $m)
        <tr>
            <td>{{ $m->id }}</td>

            <td>
            <img src="{{ $m->category_name == 'Games' ?  Storage::url($m->media_file)  : Storage::url('public/default_image.jpeg')  }}"
            height="75" width="75" alt="" /></td> 

            <td>{{ $m->title }}</td>
            <td>{{ $m->description }}</td>
            <td>{{ $m->category_name }}</td>
            <td>
            <a class="btn btn-primary btn-sm" href="{{ route('media.edit', $m->id) }}">Edit</a>
            <button type="submit" data-id="{{ $m->id }}"  data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId" >Delete</button>

            </td>
            
        </tr>
        @endforeach
    </table>
  
  

    <!-- Delete Article Modal -->
<div class="modal" id="DeleteArticleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Media Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Media?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteArticleForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
    $(document).ready(function() {
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })

        $('#SubmitDeleteArticleForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "media/"+id,
                method: 'DELETE',
                success: function(result) {
                    setInterval(function(){ 
                        $('#DeleteArticleModal').hide();
                    }, 1000);
                }
            });
        });
    });
    </script>
@stop