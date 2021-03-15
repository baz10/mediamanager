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
            <th>Media</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($media as $m)
        <tr >
            <td>{{ $m->id }}</td>

            <td><a href="#" class="pop">


            <img class="show_img" src="{{ $m->category_name == 'Games' ?  Storage::url($m->media_file)  : asset('images/default_image.jpeg')  }}"
            height="75" width="75" alt="" /></a></td> 

            <td>{{ $m->title }}</td>
            <td>{{ $m->description }}</td>
            <td>{{ $m->category_name }}</td>
            <td>
    
            <a class="btn btn-primary  btn-sm openMedia" id ="{{ Storage::url($m->media_file) }}" href="#" data-id="{{ $m->fk_category_id }}">View</a>
            <a class="btn btn-primary  btn-sm" href="{{ route('media.edit', $m->id) }}">Edit</a>
            <!-- <button type="submit" data-id="{{ $m->id }}"  data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId" >Delete</button> -->
            <form action="{{ route('media.destroy', $m->id) }}" method="POST">

                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
            
            
        </tr>
        @endforeach
    </table>

  
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">              
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div id="preview"></div>


           

        </div>
        </div>
    </div>
    </div>
  
  

    <!-- Delete Media Modal -->
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

        
        $(function() {
            $('.openMedia').on('click', function() {
                var cat_id = $(this).data("id");
                var id = $(this).attr("id");
                if(cat_id == 1){
                    $('#preview').append('<video id="videopreview" width="400" controls> <source src=" ' + id + '" ></video>');
                }
                else if( cat_id == 2){
                    $("#preview").html("");
                    $('#preview').append( '<audio id="musicpreview" controls><source src=" ' + id + '" ></audio>');
                   
                }
                else
                {
                    $("#preview").html("");
                    $('#preview').append('<img src=" ' + id + '" id="imagepreview" style="width: 100%;" >');
                    
                }
                $('#imagemodal').modal('show');   
            });		
        });
    });


    </script>
@stop