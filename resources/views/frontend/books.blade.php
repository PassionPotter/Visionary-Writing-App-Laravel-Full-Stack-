@extends('frontend.layouts.master')

@push('metatag')
    <meta property="og:url"                content="{{ Request::fullUrl() }}" />
    <meta property="og:type"               content="author" />
    <meta property="og:title"              content="{{$author->name}}" />
    <meta property="og:description"        content="{{$author->profile->about}}" />
    <meta property="og:image"              content='{{asset('public/books/avatars/T-'.$author->profile->avatar)}}' />
@endpush
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <div class="about_page_wrapper">
  <div class="container">
      

<?php 
    $pageLink = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $showAds = true;
    
    foreach($rlinks as $restrictedlink){
        if($restrictedlink->link == $pageLink){
            $showAds = false;
        }
    }


foreach($rkeywords as $restrictedKeyword){
    if (strpos($author->name, $restrictedKeyword->keyword) !== false) {
        $showAds = false;
    }
    if(strpos($author->profile->about,$restrictedKeyword->keyword) !== false) {
        $showAds = false;
    }
    foreach($author_books as $books){
        if(strpos($books->title,$restrictedKeyword->keyword) !== false) {
            $showAds = false;
        }
    }
}



?>
              @if($showAds)
                 @foreach($topAd as $ads)
                   {!! $ads->code !!} 
                  @endforeach
              @endif
           

      <div class="author_dtls clearfix">
            <div class="author_pic">

            {{-- <img data-src="{{asset('public/books/avatars/T-'.$author->profile->avatar)}}" class="lazyload" alt=""> --}}
           <?php if (isset($author->profile->avatar) && file_exists(public_path('books/avatars/T-'.$author->profile->avatar))) { ?>
                               <img data-src="{{asset('public/books/avatars/T-'.$author->profile->avatar)}}" class="img-responsive center-block lazyload" />
                        <?php } 

                        else if ($author->profile->avatar) { ?>
                          <img src="{{asset('public/books/avatars')}}/{{$author->profile->avatar}}" class="profile-image" alt="Responsive Image">
                       <!-- <a  href = "{{route('user.profile')}}"><i class="fa fa-pencil-square-o edit" aria-hidden="true"></i></a> -->
                       <?php } 

                        else { ?>
                               <img data-src="{{asset('public/books/avatars/avatar.png')}}" class="img-responsive center-block lazyload" />
                        <?php } ?>

            </div>
            <div class="author_profile_dtls">
                <div class="author_name">{{$author->name}}</div>
                <p><span>DOB:</span>{{$author->profile->dob}}</p>
                <p><span>Gender:</span> {{$author->profile->gender}}</p>
               <!--  <p><span>Books:</span> ale</p> -->
                <p><span>Views:</span> {{$authors_view_count}}</p>
            </div>
        </div>

            <p>SHARE THIS TO</p>
        	<?php $rul =Request::fullUrl(); ?>
			<a href="https://www.facebook.com/sharer/sharer.php?u={{ $rul }}&caption={{$author->name}}&description={{$author->profile->about}}"
    target="_blank">

   <i class="fa fa-3x fa-facebook-square"></i>
</a>

 <!-- <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-text="custom share text" data-url={{ $rul }}
    target="_blank"> -->
    <a href="https://twitter.com/intent/tweet?url={{ urlencode($rul) }}&text=Author name : {{$author->name}}"target="_blank">
   <i class="fa fa-3x fa-twitter-square"></i>
</a>
<a href="whatsapp://send?text={{ $rul }}"
    target="_blank">
   <i class="fa fa-3x fa-whatsapp"></i>
</a>


        <div class="about_author_details">
        	<div class="about_author_content">
          		<h2>About Author</h2>
          		<?php $new_str = str_replace("&nbsp;", '', $author->profile->about); 
          		
          		$new_str = str_replace("&amp;", '', $new_str);
          		?>
            	<p>{{strip_tags($new_str)}}</p>
            </div>
            <?php 
                $bookCount = 1;
                $countOfMiddleAds = count($afterTwoBooks);
                $serialOfMiddleAds = 0;
            ?>
             @foreach($author_books as $books)
                <div class="book_col clearfix">
                  <div class="book_image">
                      <div>
                        @if($books->book_cover && file_exists(public_path('books/uploads/T-'.$books->book_cover)))
                        <img data-src="{{asset('public/books/uploads/T-'.$books->book_cover)}}" class="lazyload" alt="" >
                        @elseif($books->book_cover && file_exists(public_path('books/uploads/'.$books->book_cover)))
                        <img data-src="{{asset('public/books/uploads/'.$books->book_cover)}}" class="lazyload" alt="" >
                        @else
                        <img data-src="{{asset('public/books/uploads/T-no_image.png')}}" alt="" class="lazyload" style=" width: 100%; ">
                         @endif
                      </div>
                  </div>
                    <div class="book_details">
                      <h3>{{$books->title}}</h3>
                        <span><strong>Genre</strong>:</span>{{$books->genre ? $books->genre : 'N/A'}}
                        <p><span>Views:</span>{{$books->view_count}}</p>
			 
                         @if($books->complete)
                        <a class="buttons read_btt" href="#" style=" border-radius: 20px; !important; font-size: 12px; width: 60px;">Complete</a> <br/>
                        @endif
			 
                        
                        <a class="buttons read_btt" href="{{route('author/book/book_id',['author' =>$author->name, 'auhtorId' =>$author->id, 'book' =>$books->slug, 'id' => $books->id])}}">Read Book</a>
                    </div>
                </div>
                <?php
                    if($bookCount % 2 == 0){
                        if($serialOfMiddleAds < $countOfMiddleAds){
                            if($showAds){
                                echo "<div style='margin-top:15px;margin-bottom:15px;'>".$afterTwoBooks[$serialOfMiddleAds]['code']."</div>";
                            }
                            $serialOfMiddleAds++;
                        }     
                    }
                    $bookCount++;
                ?>
            @endforeach
        </div>
        {{$author_books->links()}}
         
    </div>
    @if($showAds)
         @foreach($bottomAd as $ads)
          {!! $ads->code !!}
        @endforeach
    @endif
        
</div>
   @endsection


  

   
         
