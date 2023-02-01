<?php

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
?>
@extends('frontend.layouts.master')
@section('content')
<!-- content -->
<!-- <link href="{{asset('css/owlcarousel/docs.theme.min.css')}}" rel="stylesheet" type="text/css" media="all" /> -->
<link href="{{asset('css/owlcarousel/owl.carousel.css')}}" rel="stylesheet" type="text/css" media="all" />
<link href="{{asset('css/owlcarousel/owl.theme.css')}}" rel="stylesheet" type="text/css" media="all" />

<style>
    .margin-bottom-20 {
        margin-bottom: 20px;
    }
</style>
<script>
    $(document).ready(function() {
        $("#owl-demo3").owlCarousel({
            loop: true,
            autoPlay: 3000,
            items: 4,
            navigation: false,
            pagination: false,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]
        });

    });
</script>

<div class="container" style="margin-top:10px">
    <h3 class="clearfix"><span style="display: inline-block;float: left;">New Authors</span> 
       <span class="blog-post" style="display: inline-block;float: right; margin-bottom: 10px;"><a class="btn btn-block btn-info" href="{{route('allauthors')}}">View All</a></span>
    </h3>
    <br>
    <div class="row mobileviewclass owl-slider">

        <div class="col-md-12">
            <div class="owl-carousel" id="owl-demo3">
                @foreach($newAuthors as $newAuth)
                <div class="item">
                    <div class="panel panel-default">
                        <div class="panel152" style="min-height: 260px; max-height: 260px; overflow: hidden;">
                       <a href="{{route('author/author_id',['id' => $newAuth->id])}}">
                            <!-- <img src="https://visionarywritings.b-cdn.net/books/avatars/{{$newAuth->profile->avatar}}" class="img-responsive center-block" />-->

                            <?php if (isset($newAuth->profile->avatar) && file_exists(public_path('books/avatars/T-'.$newAuth->profile->avatar))) { ?>
                                <img data-src="{{asset('public/books/avatars/T-'.$newAuth->profile->avatar)}}" class=" responsive lazyload" style="width: 100%; height: auto;" />
                            <?php }

                            else if (file_exists(public_path('books/avatars/'.$newAuth->profile->avatar))) { ?>
                          <img data-src="{{asset('public/books/avatars')}}/{{$newAuth->profile->avatar}}" class=" responsive lazyload" style="width: 100%; height: auto;" />
                       <!-- <a  href = "{{route('user.profile')}}"><i class="fa fa-pencil-square-o edit" aria-hidden="true"></i></a> -->
                       <?php } 

                             else { ?>
                                <img data-src="{{asset('public/books/avatars/avatar.png')}}" class="lazyload" style="width: 100%; height: auto;" />
                            <?php } ?>
                        </a>
                    </div>

                        <div class="panel-body">
                            <div class="blog-post-meta center">
                                <a href="{{route('author/author_id',[ 'id' => $newAuth->id])}}"><span style="color: #000;">{{$newAuth->name}}</span>
                                    <br style="display:none;">
                                    <span style="color: #000; display:none;">{{$newAuth->name}}</span><br>
                                </a>
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



<div class="container" style="margin-top:10px">
    <h3 class="clearfix"><span style="display: inline-block;float: left;">Featured Books</span> <span class="blog-post" style="display: inline-block;float: right; margin-bottom: 10px;"><a class="btn btn-block btn-info" href="{{route('allbooks')}}">View featured books</a></span></h3>
    <div class="row mobileviewclass owl-slider">

        <div class="col-md-12">
            <div class="owl-carousel" id="owl-demo">
                @foreach($newRelease as $book)
                <div class="item">
                    <div class="panel panel-default">
                        <div class="panel152" style="min-height: 260px; max-height: 260px; overflow: hidden;">
                            @if($book->book_cover && file_exists(public_path('books/uploads/T-'.$book->book_cover)))
                            <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                                <!-- <img src="/books/uploads/{{$book->book_cover}}" alt=""  style="width: 100%; height: auto;"> -->
                                <img data-src="{{asset('public/books/uploads/T-'.$book->book_cover)}}" alt="" class="lazyload" style="width: 100%; height: auto;">
                            </a>
                            @elseif($book->book_cover && file_exists(public_path('books/uploads/'.$book->book_cover)))
                            <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                                <img data-src="{{asset('public/books/uploads/'.$book->book_cover)}}" alt="" class="lazyload" style="width: 100%; height: auto;">
                                </a>
                            @else
                            <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}">
                                <img data-src="{{asset('public/books/uploads/T-no_image.png')}}" alt="" class="lazyload" style=" width: 100%; ">
                            </a>
                            @endif
                        </div>

                        <div class="panel-body">
                            <div class="blog-post-meta center">
                                <a href="{{route('author/book/book_id',['author' =>$book->name, 'auhtorId' =>$book->user_id, 'book' =>$book->slug, 'id' => $book->id])}}"><span style="color: #000;">{{ $book->title }}</span>
                                    <br style="display:none;">
                                    <span style="color: #000; display:none;">By : {{ $book->name }}</span><br>
                                </a>
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
            items: 4,
            navigation: false,
            pagination: false,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]
        });

    });
</script>
<style>
    #owl-demo .item {
        margin: 10px;
    }

    @media (max-width: 599px) {
        #owl-demo .item {
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

<div class="container">
    <!-- removed class mobileview -->
    <h3 class="margin-bottom-20"><span>All Authors</span></h3>
    <div class="row mobileviewclass">
        <!-- @foreach($recent_users as $user)

        <?php 
            if ($user->admin == 1) {
                continue;
            }
         $imag =  DB::select(DB::raw("SELECT avatar FROM `profiles` WHERE user_id=$user->user_id "));
         ?>


        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 mobiledevice">
            <section class="blog-post">
                <div class="panel panel-default">
                    <a href="{{route('author/author_id',['id' => $user->user_id])}}">
                        <img data-src="{{asset('public/books/avatars/T-'.$imag[0]->avatar)}}" class="img-responsive center-block lazyload" />
                    </a>
                    <div class="panel-body">
                        <div class="blog-post-meta">
                            <a href="{{route('author/author_id',['id' => $user->user_id])}}">
                                <span class="badge badge-info">{{$user->name}}</span>
                            </a>
                        </div>
                        <div class="blog-post-content">
                            <a class="btn btn-block btn-info" href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->user_id])}}">
                                View booksdd
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @endforeach -->
        @foreach($users as $user)
        @if($newAuth->reader == 1)
                 <?php continue; ?>
                @endif
        <?php 
            if ($user->admin == 1) {
                continue;
            }
            
         $imag =  DB::select(DB::raw("SELECT avatar FROM `profiles` WHERE user_id=$user->user_id "));
          
         ?>


        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 mobiledevice">
            <section class="blog-post">
                <div class="panel panel-default">
                    <a href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->user_id])}}">

                        <?php if (isset($newAuth->profile->avatar) && file_exists(public_path('books/avatars/T-'.$imag[0]->avatar))) { ?>
                               <img data-src="{{asset('public/books/avatars/'.$imag[0]->avatar)}}" class="img-responsive center-block lazyload" />
                        <?php } 

                        else if ($imag[0]->avatar) { ?>
                          <img data-src="{{asset('public/books/avatars')}}/{{$imag[0]->avatar}}" class=" img-responsive center-block lazyload" style="" />
                       <!-- <a  href = "{{route('user.profile')}}"><i class="fa fa-pencil-square-o edit" aria-hidden="true"></i></a>1133 -->
                       <?php } 

                        else { ?>
                               <img data-src="{{asset('public/books/avatars/avatar.png')}}" class="img-responsive center-block lazyload" />

                               <!-- <a  href = "{{route('user.profile')}}"><i class="fa fa-pencil-square-o edit" aria-hidden="true"></i></a>cvvv1122 -->
                        <?php } ?>
                    </a>
                    <div class="panel-body">
                        <div class="blog-post-meta">
                            <a href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->user_id])}}">
                                <span class="badge badge-info">{{$user->name}}</span>
                            </a>
                        </div>
                        <div class="blog-post-content">
                            <a class="btn btn-block btn-info" href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->user_id])}}">
                                View books
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @endforeach
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

           {{ $users->links() }}
 
        </div>
        



    </div>
</div><!-- /.container -->

<!-- content -->

<script type="text/javascript">
    $( document ).ready(function() {
     
    });
</script>
@endsection
