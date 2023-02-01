 
@extends('frontend.layouts.master')

@push('metatag')
<meta property="og:url"                content="{{ Request::fullUrl() }}" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="{{$author->name}}" />
<meta property="og:description"        content="{{$book->description}}" />
<meta property="og:image"              content='@if($book->book_cover && file_exists(public_path("books/uploads/".$book->book_cover))){{asset("public/books/uploads/".$book->book_cover)}}@elseif($book->book_cover && file_exists(public_path("books/uploads/T-".$book->book_cover))){{asset("public/books/uploads/".$book->book_cover)}}@else{{asset("public/books/uploads/T-no_image.png")}}@endif' />
@endpush

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style type="text/css">
  .button {
  background-color: white; /* Green */
  color: #ff6e08;
  font-weight: bold;
  border: 2px solid #ff6e08;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}
.button:hover{
  text-decoration: none;
  background-color: #ff6e08; /* Green */
  color: white;
}
</style>

<div class="book_page_wrapper">
  <div class="container">
    <?php 
    $pageLink = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $showAds = true;


    foreach($restrictedlinks as $restrictedlink){
      if($restrictedlink->link == $pageLink){
        $showAds = false;
      }
    }
    foreach($restrictedKeywords as $restrictedKeyword){
      foreach($chapters as $chapter){
        if(strpos(strtolower($chapter->title), strtolower($restrictedKeyword->keyword)) !== false){
          $showAds = false;
        } 
      }  
    }
    foreach($restrictedKeywords as $restrictedKeyword){
      if(strpos(strtolower($book->title), strtolower($restrictedKeyword->keyword)) !== false){
        $showAds = false;
      }  
    }
    foreach($restrictedKeywords as $restrictedKeyword){
      if(strpos(strtolower($author->name), strtolower($restrictedKeyword->keyword)) !== false){
        $showAds = false;
      }  
    }
    foreach($restrictedKeywords as $restrictedKeyword){
      if(strpos(strtolower($book->description), strtolower($restrictedKeyword->keyword)) !== false){
        $showAds = false;
      }  
    }

    ?>

    @if($showAds)
    @foreach($topAd as $ads)
    {!! $ads->code !!} 
    @endforeach
    @endif
    <div class="book_dtls clearfix">
      <div class="book_pic">
       @if($book->book_cover && file_exists(public_path('books/uploads/'.$book->book_cover)))
        <img src="{{asset('public/books/uploads/'.$book->book_cover)}}" alt="">
       @elseif($book->book_cover && file_exists(public_path('books/uploads/T-'.$book->book_cover)))
        <img src="{{asset('public/books/uploads/T-'.$book->book_cover)}}" alt="">
       @else
        <img src="{{asset('public/books/uploads/T-no_image.png')}}" alt="">
       @endif
     </div>
     <div class="book_info">
      <h2>{!! $book->title!!}</h2>
      <p>
        <strong>Author :</strong> 
        <a class="button button1" href="{{route('author/books/author_id',['author' =>$author->name, 'id' => $author->id])}}">
          {{$author->name}}
        </a>
      </p>
      <p><strong>Genre :</strong>&nbsp;&nbsp;
        @isset($book->genre)
        <a class="button button1" href="{{route('genre',['genre' => $book->genre])}}">{{ $book->genre }}</a>
        @else
        N/A
        @endif
      </p>
      <?php
      $new_str = str_replace("&nbsp;", '', $book->description);
      $new_str = str_replace("&amp;", '&',  $new_str);
      ?>
      <p><strong>Description :</strong>&nbsp;&nbsp;{{strip_tags($new_str)}}</p>

      {{--            {{ strip_tags($book->description) }}--}}
      <!--<p><strong>Description:</strong> </p>-->
      <p><strong>Views :</strong> {{$book_view_count}}</p>
       @if($book->complete)
                        <a class="buttons read_btt" href="#" style=" border-radius: 20px; !important; font-size: 12px; width: 60px;">Complete</a> <br/>
                        @endif
    </div>

  </div>
  <?php $rul =Request::fullUrl(); ?>
  <p>SHARE THIS TO</p>
  <a href="https://www.facebook.com/sharer/sharer.php?u={{ $rul }}&caption={{$book->title}}&description={{$book->description}}"
    target="_blank">
    <i class="fa fa-3x fa-facebook-square"></i>
  </a>
  <a href="https://twitter.com/intent/tweet?url={{ urlencode($rul) }}&text=Book name : {{$book->title}}"
    target="_blank">
    <i class="fa fa-3x fa-twitter-square"></i>
  </a>
  <a href="whatsapp://send?text={{ $rul }}"
  target="_blank">
  <i class="fa fa-3x fa-whatsapp"></i>
</a>



<div class="book_details_info">
  <div class="row">
    <div class="col-md-8">
      <?php 
      $bookCount = 1;
      $countOfMiddleAds = count($afterTwoChapters);
      $serialOfMiddleAds = 0;
      ?>
      <?php $i=1; ?>
      @foreach($chapters as $chapter)
      <div class="book_info_col">
        <h3>{!! $chapter->title !!}</h3>
        <a class="label label-light label-info" href="{{route('author/book/chapter_id',['author' =>$author->name, 'auhtorId' =>$author->id, 'book' =>$book->slug, 'bookId'=>$book->id, 'chapter' =>$chapter->slug, 'id' => $chapter->id])}}">Read More</a>
        <?php
        if($bookCount % 2 == 0){
          if($serialOfMiddleAds < $countOfMiddleAds){
            if($showAds){
              $new_str = str_replace("&nbsp;", '', $afterTwoChapters[$serialOfMiddleAds]['code']);
              $new_str = str_replace("&amp;", '&', $new_str);
              echo "<div style='margin-top:45px;margin-bottom:15px;'>".$new_str."</div>";
            }
            $serialOfMiddleAds++;
          }     
        }
        
        $bookCount++;
        ?>
      </div>
      @endforeach 
      {{$chapters->links()}}   
    </div>

    <div class="col-md-4">
      @if($showAds)
      @foreach($bottomAd as $ads)
      {!! $ads->code !!} 
      @endforeach
      @endif

    </div>
  </div>    
</div>
</div>
</div>
@endsection

 
