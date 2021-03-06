@extends('layouts.backend.app')
@section('title', 'EDIT CATEGORY')
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
                                Edit Category Form                         
                            </h2>
                        </div>
                        <div class="body">
                        <form Action="{{route('admin.category.update', $category->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control" name="name" value="{{$category->name}}">
                                        <label class="form-label">Category Name</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="file" name="image">
                                </div>
                                <a href="" class="btn btn-danger m-t-15 waves-effect" href="{{route('admin.category.index')}}">Back</a>
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