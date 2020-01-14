@extends('layouts.frontend.app')
@section('title', 'Post')
@push('css')
<link href="{{asset('public/assets/frontend/css/allpost/styles.css')}}" rel="stylesheet">
<link href="{{asset('public/assets/frontend/css/allpost/responsive.css')}}" rel="stylesheet">
<style rel="stylesheet">

</style>
@endpush
@section('content')
<div class="slider display-table center-text">
		<h1 class="title display-table-cell"><b>{{$tag->name}}</b></h1>
	</div><!-- slider -->
<section class="blog-area section">
		<div class="container">

			<div class="row">
				@if (!$posts->count() == 0)
					@foreach ($posts as $row)
					<div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="{{asset('public/storage/post/'.$row->image)}}"></div>

							<a class="avatar" href="{{route('author.profile',$row->user->username)}}"><img src="{{asset('public/storage/profile/'.$row->user->image)}}"></a>

							<div class="blog-info">

							<h4 class=""><a href="{{route('post.details',$row->slug)}}"><b>{{$row->title}}</b></a></h4>

								<ul class="post-footer">
									<li>
									@guest
										<a href="javasript:void(0)" onclick="toastr.info('You have to login first', 'info', {
											progressBar : true,
											closeButton : true
										})"><i class="ion-heart"></i>{{$row->favorite_to_users->count()}}</a>
									
										@else
									<a 	href="#" onclick="document.getElementById('favourite-form-{{$row->id}}').submit();" class="{{!Auth::user()->favorite_posts->where('pivot.post_id', $row->id)->count() == 0 ? 'text-danger' : ''}}">
									<i class="ion-heart"></i>{{$row->favorite_to_users->count()}}</a>

									<form id="favourite-form-{{$row->id}}" action="{{route('favourite.post',$row->id)}}" method="post" style="display:none">
										@csrf
									</form>
									@endguest




									</li>
									<li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
									<li><a href="#"><i class="ion-eye"></i>{{$row->view_count}}</a></li>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div><!-- col-lg-4 col-md-6 -->
				@endforeach
				@else
				No Post Available!
				@endif
				

			</div><!-- row -->

			       {{-- {{$category->posts->links()}} --}}
			
		</div><!-- container -->
	</section><!-- section -->
	

@endsection
@push('js')
@endpush