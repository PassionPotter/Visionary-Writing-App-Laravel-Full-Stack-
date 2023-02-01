<!-- header -->
<?php
use Illuminate\Support\Facades\Auth;

// Get the currently authenticated user...
$user = Auth::user();
// print_r($user['name']);die;
?>
<link rel="stylesheet" href="{{ asset('css/new.css') }}">

<div class="banner">
	<div class="container">
		<div class="header">
			<div class="logo">
				<a href="{{route('home')}}"><img src="https://visionarywritings.com/images/logo.png" class="img-responsive" alt="" width="100px" height="100px" style="border-radius:50px"/></a>
			</div>
			<div class="header-right">
				<ul>
					<li><a href="https://www.facebook.com/visionarywritings/"><i class="fb"> </i></a></li>
					<li><a href="https://twitter.com/VWritings"><i class="twt"> </i></a></li>
					<li>
						<div class="search2">
							<form action="{{route('results')}}" method="GET">
								<input type="text" value="Search" name="query" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
								<input type="submit" value="">
							</form>
						</div></li>
						<div class="clearfix"></div>
					</ul>
					
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="head-nav">
				<span class="menu"> </span>
				<ul class="cl-effect-15">
					<li class="active"><a href="{{route('home')}}">HOME</a></li>
					<li><a href="{{asset('about')}}" data-hover="ABOUT">ABOUT</a></li>
					<li><a href="{{route('contact')}}" data-hover="CONTACT">CONTACT</a></li>
					<li><a href="https://writingsmarket.com/"> MARKET</a></li>
					<li>
						<!-- <a href="{{route('register-author')}}" >Join Us</a> -->
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Join Us</a>
						
						<ul class="dropdown-menu" style="top: auto;left: auto;">
							<li><a href="{{route('register')}}">Become an Author</a></li>
							<li><a href="{{route('regAsReader')}}">Become a Reader</a></li>
						</ul>
					</li>

					<li><a href="{{route('login')}}" ><?= !empty($user['name']) ? 'Profile' : 'Sign In'; ?></a></li>
					<div class="clearfix"> </div>
				</ul>
			</div>

			<!-- script-for-nav -->
			<script>
				$( "span.menu" ).click(function() {
					$( ".head-nav ul" ).slideToggle(300, function() {
							// Animation complete.
						});
				});
			</script>
			<!-- script-for-nav --> 					 
		</div> 
	</div>
<!-- header -->