@extends('frontend.layouts.master')
@section('content')
<!-- content -->
<!-- <link href="{{asset('css/owlcarousel/docs.theme.min.css')}}" rel="stylesheet" type="text/css" media="all" /> -->
<link href="{{asset('css/owlcarousel/owl.carousel.css')}}" rel="stylesheet" type="text/css" media="all" />
<link href="{{asset('css/owlcarousel/owl.theme.css')}}" rel="stylesheet" type="text/css" media="all" />

<style>
.margin-bottom-20{
margin-bottom: 20px;
}
</style>


<div class="container" style="padding-top:40px">
  <div class="row mobileviewclass">
     <h3 class="margin-bottom-20"><span>New Authors</span></h3>
    <div class="">

      @foreach($newAuthors as $newAuth) 
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mobiledevice">
              <section class="blog-post">
                <div class="panel panel-default">
                  <a href="{{route('author/books/author_id',['author' =>$newAuth->name, 'id' => $newAuth->id])}}">
                  <img src="{{asset('books/avatars/'.$newAuth->profile->avatar)}}" class="img-responsive center-block" />
                </a>
                  <div class="panel-body">
                    <div class="blog-post-meta">
                      <span class="badge badge-info">{{$newAuth->name}}</span>
                      <!-- <p class="blog-post-date pull-right"><span class="glyphicon glyphicon-book"></span> {{$newAuth->books->count()}}</p> -->
                    </div>
                    <!-- <div class="blog-post-content">
                      <a class="btn btn-block btn-info" href="{{route('author/books/author_id',['author' =>$newAuth->name, 'id' => $newAuth->id])}}">View books</a>
                    </div> -->
                  </div>
                </div>
                </section>
      </div>
            @endforeach

    </div>
  </div>
</div>

<hr style="border: 5px solid #f2f2f2;">



<div class="container" style="margin-top:10px">
  <h3 class="clearfix"><span style="display: inline-block;float: left;">New Release</span> <span class="blog-post" style="display: inline-block;float: right; margin-bottom: 10px;"><a class="btn btn-block btn-info" href="{{route('allbooks')}}">View books</a></span></h3>
<div class="row mobileviewclass owl-slider">
  
  <div class="col-md-12">   
          <div class="owl-carousel" id="owl-demo">
           @foreach($newRelease as $book) 
            <div class="item">              
                <div class="panel panel-default">
                  <div class="panel152" style="min-height: 260px; max-height: 260px; overflow: hidden;">
                  @if($book->book_cover && file_exists(public_path('books/uploads/'.$book->book_cover)))
                  <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                  <img src="{{asset('public/books/uploads/'.$book->book_cover)}}" alt=""  style="width: 100%; height: auto;">
                  </a>
                  @elseif($book->book_cover && file_exists(public_path('books/uploads/T-'.$book->book_cover)))
                  <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                  <img src="{{asset('public/books/uploads/T-'.$book->book_cover)}}" alt=""  style="width: 100%; height: auto;">
                  </a>
                  @else
                  <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                  <img src="{{asset('public/books/uploads/T-no_image.png')}}" alt="" style=" width: 100%; ">
                </a>
                  @endif
                </div>
                  
                  <div class="panel-body">
                    <div class="blog-post-meta center">
                      <span>{{ $book->title }}</span>
                     <br>
                     <span style="color: #000;">By : {{ $book->name }}</span><br>
                    </div>
                  </div>
                </div>
            </div>
            @endforeach      
          

          
        </div>


  </div>
</div>
</div>
<hr style="border: 5px solid #f2f2f2;">



          <script src="{{asset('js/owlcarousel/owl.carousel.js')}}"></script>
          <script>
            $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        loop: true,
        autoPlay: 3000,
        items : 4,
        navigation : true,
        pagination: false,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]
      });

    });
          </script>
          <style>
    #owl-demo .item{
        margin: 10px;
    }
    @media (max-width: 599px) {
      #owl-demo .item{
        margin: 5px;
    }
    .owl-slider .col-md-12 {
      padding: 0 5px
    }
    }
    </style>
<!-- <div class="container" style="padding-top:40px">
<div class="row">
	<div class="col-md-12">
	<section class="blog-post">
		<a class="twitter-timeline" href="https://twitter.com/VWritings" data-height="100" data-chrome="nofooter noborders noheader transparent noscrollbar" data-tweet-limit="1">updates loading... please wait</a><script src="//platform.twitter.com/widgets.js" async="" charset="utf-8"></script>  <hr />
	</section>
	</div>
</div>
</div> -->
<style>

/*.book_image img {
    max-width: 100%;
    height: auto;
    margin: 0px auto;
    display: block;
    width: 54%;
}
.book_image {
    float: left;
    max-width: 260px;
    margin: 0px;
    padding: 0px;
    height: 130px;
    width: 130px;
    background: #F5F5F5 none repeat scroll 0% 0%;
    border-radius: 2px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}*/
</style>
 <div class="container mobileview">
	<h3 class="margin-bottom-20"><span>All Authors</span></h3>
    <?php try {  //echo "<pre>"; print_r($items);exit;  ?>
          <div class="row mobileviewclass">
			  @foreach($users as $user)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 mobiledevice">
              <section class="blog-post">
                <div class="panel panel-default">
                  <img src="{{asset('books/avatars/'.$user->profile->avatar)}}" class="img-responsive center-block" />
                  <div class="panel-body">
                    <div class="blog-post-meta">
                      <span class="badge badge-info">{{$user->name}}</span>
                      <p class="blog-post-date pull-right"><span class="glyphicon glyphicon-book"></span> {{$user->books->count()}}</p>
                    </div>
                    <div class="blog-post-content">
                      <a class="btn btn-block btn-info" href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->id])}}">View books</a>
                    </div>
                  </div>
                </div>
                </section>
			</div>
		  @endforeach
      <?php }catch(\Exception $e) {
                                  echo "<pre>";
                                  echo $e;
                                  echo "</pre>";
                              } ?>
		  </div>
	
              {{$users->links()}}

    </div><!-- /.container -->

<!-- content -->	
@endsection