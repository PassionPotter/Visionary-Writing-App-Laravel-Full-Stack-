@extends('frontend.layouts.master')
@section('content')
    <!-- <link href="{{asset('css/owlcarousel/docs.theme.min.css')}}" rel="stylesheet" type="text/css" media="all" /> -->
    <link href="{{asset('css/owlcarousel/owl.carousel.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('css/owlcarousel/owl.theme.css')}}" rel="stylesheet" type="text/css" media="all" />
<style>
  .comment-reply{

    display: none;
  }
  .row{
-webkit-user-select: none; /*(Chrome/Safari/Opera)*/
/*-webkit-touch-callout: none;*/
-moz-user-select: none;/*(Firefox)*/
-ms-user-select: none;/*(IE/Edge)*/
-*-user-select: none;
-khtml-user-select: none;
 user-select: none;

}
.replyComment{
    margin-left:40px;
    border-left: 3px solid #291f1a;
}
#owl-demo .item{width: 100%;}
.panel div a img{
  height: 180px !important;
  object-fit: cover
}
</style>




  <div class="container" style="padding-top:90px">
    @if(Session::has('success'))
      <div class="alert alert-success alert-block">
        {{session('success')}}
      </div>
    @endif
      <div class="row">

        <div class="col-sm-12 blog-main">
            <?php 
                $pageLink = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $showAds = true;
                
                if($chapter){
                    $content = $chapter->chapter_content;
                    $contentArr = explode(' ',$content);
                    for($ar=0; $ar< sizeof($contentArr); $ar++){
                        foreach($restrictedKeywords as $restrictedKeyword){
                            if($contentArr[$ar] == $restrictedKeyword->keyword){
                                $showAds = false;
                            }
                        }
                    }
                }
                
                foreach($restrictedlinks as $restrictedlink){
                    if($restrictedlink->link == $pageLink){
                        $showAds = false;
                    }
                }
            ?>
              @if($showAds)
                 @foreach($topAd as $ads)
                   {!! $ads->code !!} 
                  @endforeach
              @endif
          <section class="blog-post">
              <!-- <div class="panel ">
                    <div class="panel-body a_pannel_class">
                        <div class="author_dtls clearfix">
                            <div class="author_pic" style="">
                                @if($book->book_cover)
                                        <img src="{{asset('books/uploads/'.$book->book_cover)}}" style="" alt="">
                                @else
                                        <img src="{{asset('books/uploads/T-no_image.png')}}" alt="">
                                @endif
{{--                              <img src="{{asset('books/avatars/'.$author->profile->avatar)}}" alt="">--}}
                            </div>
                            <div class="author_profile_dtls">
                                <div class="author_name">{{$book->title}}</div>
                                <h5><span>Author Name:</span>{!! $author->name!!}</h5>
                                <h5><span>Genre:</span>{{$book->genre ? $book->genre : 'N/A'}}</h5>
                               
                            </div>
                        </div>
                </div>
            </div>-->
{{--              <div class="book_col clearfix">--}}
{{--                  <div class="book_image">--}}

{{--                          <img src="{{asset('books/avatars/'.$author->profile->avatar)}}" alt="">--}}

{{--                  </div>--}}
{{--                  <div class="book_details">--}}
{{--                      <h3>{{$author->name}}</h3>--}}
{{--                      <h3>{!! $book->title!!}</h3>--}}
{{--                    </div>--}}
{{--              </div>--}}



          </section><!-- /.blog-post -->
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"><h4>{{$chapter ? $chapter->title : 'No title available'}}</h4></div>
      <div class="panel-body">
          <p>
          @if($chapter)
            <?php 
                $content = $chapter->chapter_content;
                $contentArr = explode(',',$content);
                for($v=0; $v < (count($contentArr)/2); $v++){
                    echo $contentArr[$v];
                }
                if(!empty($inChapterAd)){
                    if($showAds){
                        $new_str = str_replace("&nbsp;", '', $inChapterAd[0]['code']);
                        $new_str = str_replace("&amp;", '&', $new_str);
                       echo "<div style='margin:15px 0px;'>".$new_str."</div>";
                    }
                }
                for($v=(count($contentArr)/2); $v < count($contentArr); $v++){
                    echo $contentArr[$v];
                }
            ?>
          @else
            {{'No content available'}}
          @endif
          
          </p></div>
    </div>
  </div>
        </div>
      </div>
		<div class="author_nav">
		
			<div class="all_chapter">
				<form class="form-horizontal" >
					{!!  csrf_field() !!}
					<select id="sel_chapter" name="sel_chapter">
						@foreach($chapters_dropdown as $chapter_val)
							<option value="{!! $chapter_val->id!!}">{!! $chapter_val->title!!}</option>				
						@endforeach 					
					</select>
					<a class="chapter_open" href="#" target="_blank">Open</a>
				</form>
			</div>
			<div class="main_nav">
				<a href="{{route('author/book/book_id',['author' =>$author->name, 'auhtorId' =>$author->id, 'book' =>$book->slug, 'id'=>$book->id])}}">Go to Main Book</a>
			</div>
		    <nav class="right">
				<ul class="pager">
				  @if($previous_chapter)
				  <li><a class="withripple" href="{{route('author/book/chapter_id',['author' =>$author->name, 'auhtorId' =>$author->id, 'book' =>$book->slug, 'bookId'=>$book->id, 'chapter' =>$previous_chapter->slug, 'id' => $previous_chapter->id])}}">Previous</a>
				  <!--{{'author/book/chapter_id/'.$author->name.'/auhtorId/'.$author->id.'/book/'.$book->title.'/bookId/'.$book->id.'/chapter/'.$previous_chapter->slug.'/id/'.$previous_chapter->id}}-->
				  </li>
				  
				  @endif
				  @if($next_chapter)
				  <li><a class="withripple" href="{{route('author/book/chapter_id',['author' =>$author->name, 'auhtorId' =>$author->id, 'book' =>$book->slug, 'bookId'=>$book->id, 'chapter' =>$next_chapter->slug, 'id' => $next_chapter->id])}}">Next</a>
				  <!--<li><a class="withripple" href="{{route('author/book/chapter_id',['author' =>$author->name, 'auhtorId' =>$author->id, 'book' =>$book->title, 'bookId'=>$book->id, 'chapter' =>$book->title, 'id' => $next_chapter->id])}}">Next</a>-->
				  <!--{{'author/book/chapter_id/'.$author->name.'/auhtorId/'.$author->id.'/book/'.$book->title.'/bookId/'.$book->id.'/chapter/'.$next_chapter->slug.'/id/'.$next_chapter->id}}-->
				  </li>
				  @endif
				</ul>
			</nav>
		</div>
		@if(isset($lastChapter) && $lastChapter == true)
        <div class="container" style="margin-top:10px">
            <h3 class="clearfix"><span style="display: inline-block;float: left;">Recommended Books</span></h3>

            <div class="row mobileviewclass owl-slider">

                <div class="col-md-12">
                    <div class="owl-carousel" id="owl-demo">
                    @foreach($rec_book as $book)
                            <div class="item">
                                <div class="panel panel-default">
{{--                                    <div class="edit">--}}
                                    <div class="panel152" style="min-height: 180px; max-height: 180px; overflow: hidden;">
                                        @if($book->book_cover && file_exists(public_path('books/uploads/T-'.$book->book_cover)))
                                            <a href="{{route('author/book/book_id',['author' =>(@$book->user->name)?$book->user->name:@$book->user['name'], 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                                                <img src="{{asset('public/books/uploads/T-'.$book->book_cover)}}" alt=""  style="width: 100%;">
                                            </a>
                                        @elseif($book->book_cover && file_exists(public_path('books/uploads/'.$book->book_cover)))
                                            <a href="{{route('author/book/book_id',['author' =>(@$book->user->name)?$book->user->name:@$book->user['name'], 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                                                <img src="{{asset('public/books/uploads/'.$book->book_cover)}}" alt=""  style="width: 100%;">
                                            </a>
                                        @else
                                            <a href="{{route('author/book/book_id',['author' =>(@$book->user->name)?$book->user->name:@$book->user['name'], 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                                                <img src="{{asset('public/books/uploads/T-no_image.png')}}" alt="" style=" width: 100%; ">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="panel-body">
                                        <div class="blog-post-meta center">
                                            <span>{{ $book->title }}</span>
                                            <br>
                                            <span style="color: #000;">By : {{ (@$book->user->name)?$book->user->name:@$book->user['name'] }}</span><br>
                                    </div>
                                    </div>
{{--                                </div>--}}
								</div>
                            </div>
                        @endforeach
					</div>
				</div>
			</div>
		</div>
		@endif


<hr style="border: 5px solid #f2f2f2;">



<script src="{{asset('js/owlcarousel/owl.carousel.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            loop: true,
            autoPlay: 3000,
            items : 4,
            navigation : false,
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
    /*.blog-post-meta{*/
    /*    !*border : 1px solid red;*!*/
    /*    margin-top: -70px;*/
    /*    padding : -10px;*/
    /*    height: 80px;*/
    /*}*/
    /*.edit{*/
    /*    !*border : 1px solid red;*!*/
    /*    height: 300px;*/
    /*}*/
    @media (max-width: 599px) {
        #owl-demo .item{
            margin: 5px;
        }
        .owl-slider .col-md-12 {
            padding: 0 5px
        }
    }
</style>



        <div class="row">
       <div class="col-sm-6">
        @isset(Auth::user()->id)
        
        @if(Auth::user()->id)
       	<div class="a_comment_form_area">
          <h2>Write your opinion</h2>
          <form class="form-horizontal"  action="{{route('comment/store')}}" method="post">
           {!!  csrf_field() !!}
           <input type="hidden" class="form-control" id="chapter_id"  name="chapter_id" value="{{$chapter->id}}">
           <div class="form-group">
             <!--  <label  for="email">Email:</label> -->

             <input type="name" class="form-control" id="name" placeholder="Enter name" required name="name" value="{{ (isset(Auth::user()->name))?Auth::user()->name:'' }}">

           </div>
           <div class="form-group">
             <!--  <label  for="email">Email:</label> -->

             <input type="email" class="form-control" id="email" placeholder="Enter email" required name="email" value="{{ (isset(Auth::user()->email))?Auth::user()->email:'' }}">

           </div>
           <div class="form-group">
            <!-- label for="comment">Comment:</label> -->
            <textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Enter comment" required></textarea>
          </div>
          
          <div class="form-group">        
            <!--<div class="col-sm-offset-2 col-sm-10">-->
              <div>
                <button type="submit" class="btn btn-default">Submit</button>
              </div>
            </div>
          </form>
        </div>
        @endif
        @else
        <a href="{{url('login?comment=true')}}" class="btn Lcomment">Login to comment</a> <small>To share your opinion</small>
        @endisset
        @if(!empty($commentss))
          @foreach($commentss as $comment)
	        <?php //echo "<pre>"; print_r($comment); echo "</pre>"; ?>
                   @if($comment->status == 1)
              <div class="row">
              	<div class="a_comment_area">
                    <h2>{{$comment->user_name}} <sub>{{$comment->created_at}}</sub>
                    @if(Auth::check())
                    @if(Auth::user()->admin == 1 || Auth::user()->email == $comment->user_email || Auth::user()->id == $book->user_id)
                    <a class="btn-primary btn btn-sm pull-right" style="margin-right:10px;vertical-align:top" href="{{URL::to('edit/comment/'.$comment->id.'/'.$comment->chapter_id)}}">Edit</a>
                    @endif
                    @endif
                    </h2>

                    <p>{{$comment->comment}}</p>
                </div>
              </div>
                   @endif

               @if(count($comment->replies) > 0)
              @foreach($comment->replies as $reply)
              <div class="row">
              	<div class="a_comment_area replyComment">
                    <h2>{{$reply->user_name}} <sub>{{$reply->created_at}}</sub>
                    @if(Auth::check())
                    @if(Auth::user()->admin == 1 || Auth::user()->email == $reply->user_email || Auth::user()->id == $book->user_id)
                    <a class="btn-primary btn btn-sm pull-right" style="margin-right:10px;vertical-align:top" href="{{URL::to('edit/comment/'.$reply->id.'/'.$reply->chapter_id)}}">Edit</a>
                    @endif
                    @endif
                    </h2>
                    <p>{{$reply->comment}}</p>
                </div>
              </div>
              @endforeach
             @endif
          @endforeach
        @endif
        </div>
        <div class="col-sm-6">
          @if($showAds)
             @foreach($bottomAd as $ads)
                {!! $ads->code !!} 
              @endforeach
          @endif
        </div>
        </div>
            
          @if($showAds)
             @foreach($bottomAd as $ads)
                {!! $ads->code !!} 
              @endforeach
          @endif
        </div>
       @endsection
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>	   
<script>
	jQuery( document ).ready(function() {
		jQuery('.chapter_open').click(function() {
			window.location = jQuery('#sel_chapter').val();
		});
	});	
</script>	   
