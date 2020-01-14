@extends('layouts.backend.app')
@section('title', 'ADMIN')
@push('css')
<!-- Sweet Alert Css -->
    <link href="{{asset('public/assets/backend/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endpush
@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>FORM EXAMPLES</h2>
            </div>

           
               
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Tag Form                         
                            </h2>
                        </div>
                        <div class="body">
                        <form Action="{{route('admin.tag.update', $tag->id)}}" method="post">
                            @csrf
                            @method('PUT')
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" name="name" value="{{$tag->name}}">
                                        <label class="form-label">Tag Name</label>
                                    </div>
                                </div>
                                <a href="" class="btn btn-danger m-t-15 waves-effect" href="{{route('admin.tag.index')}}">Back</a>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->
        </div>
    </section>
       
@endsection
@push('js')
@endpush