@extends('layouts.backend.app')
@section('title', 'POST')
@push('css')
 <!-- JQuery DataTable Css -->
<link href="{{asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

@endpush
@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
            <a href="{{route('admin.post.create')}}" class="btn btn-primary waves-black">
                <i class="material-icons">add</i>
                <span>Add Post</span>
            </a>
            </div>
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                POST TABLE
                            <span class="badge bg-blue">{{$posts->count()}}</span>
                            </h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>
                                                <i class="materials-icons">visibility</i>
                                            </th>
                                            <th>Is Approved</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                         <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>
                                                <i class="materials-icons">visibility</i>
                                            </th>
                                            <th>Is Approved</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Action</th>                                           
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($posts as $key=>$row)
                                        <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$row->title}}</td>
                                                    <td>{{$row->user->name}}</td>
                                                    <td>{{$row->view_count}}</td>
                                                    <td>
                                                        @if ($row->is_approved == true)
                                                           <span class="badge bg-blue">Published</span>
                                                           @else 
                                                           <span class="badge bg-red">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($row->status == true)
                                                           <span class="badge bg-blue">Published</span>
                                                           @else 
                                                           <span class="badge bg-red">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$row->created_at}}</td>
                                                    <td class="text-center">
                                                      @if ($row->is_approved == false)
            <button type="button" onclick="approvePost({{$row->id}})" class="btn btn-success">
              <i class="material-icons">done</i>
            </button>
            <form method="POST" action="{{route('admin.post.approve', $row->id)}}" style="display:none" id="approve-form">
                @csrf
                @method('PUT')
           </form>
            @endif


                                                    <a href="{{route('admin.post.edit', $row->id)}}" class="btn btn-warning waves-effect">
                                                    <i class="material-icons">edit</i>
                                                    </a>
                                                    <a href="{{route('admin.post.show', $row->id)}}" class="btn btn-primary waves-effect">
                                                    <i class="material-icons">visibility</i>
                                                    </a>

                                                    <button type="button" class="btn btn-danger waves-effect"
                                                onclick="deletePost({{$row->id}})">
                                                    <i class="material-icons">delete</i>
                                                    </button>

                                        <form id="delete-form-{{$row->id}}" action="{{route('admin.post.destroy', $row->id)}}" method="post" style="display:none">
                                        @csrf
                                        @method('DELETE')
                                        </form>

                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        
    </section>
@endsection
@push('js')
 <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
        <script src="{{asset('public/assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>
            <script src="{{asset('public/assets/backend/js/admin.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <script type="text/javascript">
            function deletePost(id){
                const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    event.preventDefault();
      document.getElementById('delete-form-'+id).submit();
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Your Post is safe :)',
      'error'
    )
  }
})

            }
            function approvePost(id){
                const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You want to Approve this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, Approve it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    event.preventDefault();
      document.getElementById('approve-form').submit();
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Your Post Remain Unapproved :)',
      'info'
    )
  }
})

            }
            $(function () {
    //TinyMCE
    tinymce.init({
        selector: "textarea#tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = "{{asset('public/assets/backend/plugins/tinymce')}}";
});
            
            </script>


@endpush