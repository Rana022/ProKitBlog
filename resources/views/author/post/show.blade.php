@extends('layouts.backend.app')
@section('title', 'SHOW POST')
@push('css')

@endpush
@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
            <a href="{{route('admin.post.index')}}" class="btn btn-danger">Back</a>
            @if ($post->is_approved == true)
            <a href="" class="btn btn-success disabled pull-right">Approved</a>
                @else
                <a href="" class="btn btn-success pull-right">Approve</a>
            @endif
            </div>

           
               
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                                {{$post->title}}
                            <small>Author: <strong> <a href="http://">{{$post->user->name}}</a></strong>on {{$post->created_at->toFormattedDateString()}}</small>               
                            </h2>
                        </div>
                        <div class="body">
                        <p>{!!$post->body!!}</p>  
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-amber">
                            <h2>
                                Post Category                         
                            </h2>
                        </div>
                        <div class="body">
                            @foreach ($post->categories as $categories)
                        <span class="badge bg-brown">{{$categories->name}}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="header bg-blue">
                            <h2>
                                Post Tag                         
                            </h2>
                        </div>
                        <div class="body">
                            @foreach ($post->tags as $tags)
                        <span class="badge bg-amber">{{$tags->name}}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="header bg-green">
                            <h2>
                                Post Image                         
                            </h2>
                        </div>
                        <div class="body">
                        <img src="{{asset('public/storage/post/'.$post->image)}}" alt="" class="img-responsive thumbnail">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->
        </div>
    </section>
       
@endsection
@push('js')
<!-- Select Plugin Js -->
    <script src="{{asset('public/assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <!-- TinyMCE -->
    <script src="{{asset('public/assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <script>
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