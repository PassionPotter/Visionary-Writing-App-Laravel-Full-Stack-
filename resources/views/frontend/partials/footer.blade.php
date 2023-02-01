<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="col-md-3 copy">
				<div class="top2">
					<h6>Copyrights © 2020 Visionary Writings</h6>
					<p>All rights reserved</p>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="col-md-3 copy">
				<div class="top2">
					<p><a href="https://play.google.com/store/apps/details?id=com.agnitio.visionarywritings" target="_blank">
                     <img src="{{asset('public/images/en_badge_web_generic.png')}}" class="img-responsive">
                    
                    </a></p>
				</div>
				<div class="clearfix"> </div>
			</div>

				<div class="col-md-3 copy">
				<div class="top2">
					<p><a href="{{route('faq')}}"> Frequently Asked Questions </a></p>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="col-md-3 copy">
					<div class="top2">
						<p><a href="{{route('tnpp')}}"> TERMS AND PRIVACY POLICY </a></p>
					</div>
					<div class="clearfix"> </div>
				</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- footer -->

@yield('scripts')
<script type="text/javascript" src="{{asset('js/jquery.longclick-min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
	// if (!isMobile) {
		/* your code here */
		lazyload();
	// }
});
document.documentElement.style.webkitTouchCallout = 'none';
function longClickHandler(e){
  e.preventDefault();
  $("body").append("<p>You longclicked. Nice!</p>");
}
</script>
</body>
</html>