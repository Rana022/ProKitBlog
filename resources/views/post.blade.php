@extends('layouts.frontend.app')
@section('title', 'Post')
@push('css')
<link href="{{asset('public/assets/frontend/css/singlepost/styles.css')}}" rel="stylesheet">
<link href="{{asset('public/assets/frontend/css/singlepost/responsive.css')}}" rel="stylesheet">
<style rel="stylesheet">
  .post-image{
      background-image: url("{{asset('public/storage/post/'.$post->image)}}");
      width:100%;
      height: 380px;
      background-size: cover;
  }
</style>
@endpush
@section('content')
<div class="container-fluid">
<div class="post-image">
		
	</div><!-- slider -->

	<section class="post-area section">
		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-md-12 no-right-padding">

					<div class="main-post">

						<div class="blog-post-inner">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{asset('public/storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{$post->user->name}}</b></a>
									<h6 class="date">on {{$post->created_at->diffForHumans()}}</h6>
								</div>

							</div><!-- post-info -->

							<h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>
							<p class="para">{!!$post->body!!}</p>
							<ul class="tags">
                                @foreach ($post->tags as $row)
                            <li><a href="{{route('tag.posts',$row->slug)}}">{{$row->name}}</a></li>   
                                @endforeach
							</ul>
						</div><!-- blog-post-inner -->

						<div class="post-icons-area">
							<ul class="post-icons">
								<li>
									@guest
										<a href="javasript:void(0)" onclick="toastr.info('You have to login first', 'info', {
											progressBar : true,
											closeButton : true
										})"><i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>
									
										@else
									<a 	href="#" onclick="document.getElementById('favourite-form-{{$post->id}}').submit();" class="{{!Auth::user()->favorite_posts->where('pivot.post_id', $post->id)->count() == 0 ? 'text-danger' : ''}}">
									<i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>

									<form id="favourite-form-{{$post->id}}" action="{{route('favourite.post',$post->id)}}" method="post" style="display:none">
										@csrf
									</form>
									@endguest




									</li>
									<li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
									<li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
							</ul>

							<ul class="icons">
								<li>SHARE : </li>
								<li><a href="#"><i class="ion-social-facebook"></i></a></li>
								<li><a href="#"><i class="ion-social-twitter"></i></a></li>
								<li><a href="#"><i class="ion-social-pinterest"></i></a></li>
							</ul>
						</div>

						<div class="post-footer post-info">

							<div class="left-area">
								<a class="avatar" href="#"><img src="{{asset('public/storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>
							</div>

							<div class="middle-area">
								<a class="name" href="#"><b>{{$post->user->name}}</b></a>
								<h6 class="date">{{$post->created_at->diffForHumans()}}</h6>
							</div>

						</div><!-- post-info -->


					</div><!-- main-post -->
				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 no-left-padding">

					<div class="single-post info-area">

						<div class="sidebar-area about-area">
							<h4 class="title"><b>{{$post->user->name}}</b></h4>
							<p>{{$post->user->name}}</p>
						</div>

						<div class="tag-area">

							<h4 class="title"><b>CATEGORIES</b></h4>
							<ul>
								@foreach ($post->categories as $row)
                            <li><a href="{{route('category.posts',$row->slug)}}">{{$row->name}}</a></li>   
                                @endforeach
							</ul>

						</div><!-- subscribe-area -->

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section><!-- post-area -->


	<section class="recomended-area section">
		<div class="container">
			<div class="row">
               @foreach ($randompost as $row)
					<div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="{{asset('public/storage/post/'.$row->image)}}"></div>

							<a class="avatar" href="#"><img src="{{asset('public/storage/profile/'.$row->user->image)}}"></a>

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
				

			</div><!-- row -->

		</div><!-- container -->
	</section>

	<section class="comment-section">
		<div class="container">
			<h4><b>POST COMMENT</b></h4>
			<div class="row">

				<div class="col-lg-8 col-md-12">
					@guest
					<div class="comment-form">
						You Have to Login First: 
						
                          <a href="{{route('login')}}">
							  <strong>
							Click here to login
							</strong>
						</a>
						
						
					</div>
					
						@else
                        <div class="comment-form">
					<form method="post" action="{{route('comment.store',$post->id)}}">
						@csrf
							<div class="row">
								<div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
										placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
								</div><!-- col-sm-12 -->
								<div class="col-sm-12">
									<button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
								</div><!-- col-sm-12 -->

							</div><!-- row -->
						</form>
					</div><!-- comment-form -->
					@endguest


					

					<h4><b>COMMENTS({{$post->comments->count()}})</b></h4>
					@if (!$post->comments->count() == 0)
						<div class="commnets-area ">
                        @foreach ($post->comments as $row)
						<div class="comment">
							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{asset('public/storage/profile/'.$row->user->image)}}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{$row->user->name}}</b></a>
									<h6 class="date">on {{$row->created_at->diffForHumans()}}</h6>
								</div>

							</div><!-- post-info -->

						<p>{{$row->comment}}</p>

						</div>

						@endforeach
					</div><!-- commnets-area -->
					@else
					<div class="commnets-area">
						No comment available!be the first :)
					</div>
					@endif
				</div><!-- col-lg-8 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section>
</div>
	

@endsection
@push('js')
@endpush