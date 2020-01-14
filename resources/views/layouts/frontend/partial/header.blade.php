 <header>
		<div class="container-fluid position-relative no-side-padding">

			<a href="{{route('home')}}" class="logo">
			<strong>{{config('app.name')}}</strong>
			</a>

			<div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

			<ul class="main-menu visible-on-click" id="main-menu">
			<li><a href="{{route('home')}}">Home</a></li>
				<li><a href="{{route('post.all')}}">Posts</a></li>
				<li><a href="{{route('login')}}">Dashboard</a></li>
			</ul><!-- main-menu -->

			<div class="src-area">
			<form method="GET" action="{{route('search')}}">
					<button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
					<input class="src-input" type="text" placeholder="Type of search" name="query">
				</form>
			</div>

		</div><!-- conatiner -->
	</header>