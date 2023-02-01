@extends('frontend.layouts.master')
@section('content')

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


/*foreach($rkeywords as $restrictedKeyword){
    if (strpos($author->name, $restrictedKeyword->keyword) !== false) {
        $showAds = false;
    }
    if(strpos($author->profile->about,$restrictedKeyword->keyword) !== false) {
        $showAds = false;
    }
    foreach($all_books as $books){
        if(strpos($books->title,$restrictedKeyword->keyword) !== false) {
            $showAds = false;
        }
    }
}*/



?>
              @if($showAds)
                 @foreach($topAd as $ads)
                   {!! $ads->code !!} 
                  @endforeach
              @endif
              

        <div class="about_author_details">

            <?php 
                $bookCount = 1;
                $countOfMiddleAds = count($afterTwoBooks);
                $serialOfMiddleAds = 0;
            ?>
             @foreach($all_books as $books)
                <div class="book_col clearfix">
                  <div class="book_image">
                      <div>
                      @if($books->book_cover && file_exists(public_path('books/uploads/T-'.$books->book_cover)))
                        <img src="{{asset('public/books/uploads/T-'.$books->book_cover)}}" alt="" >
                      @elseif($books->book_cover && file_exists(public_path('books/uploads/'.$books->book_cover)))
                        <img src="{{asset('public/books/uploads/'.$books->book_cover)}}" alt="" >
                      @else
                        <img src="{{asset('public/books/uploads/T-no_image.png')}}" alt="" style=" width: 100%; ">
                      @endif
                      </div>
                  </div>
                    <div class="book_details">
                      <h3>{{$books->title}}</h3>
                        <p><span>Views:</span>{{$books->view_count}}</p>
                        @if($books->complete)
                        <a class="buttons read_btt" href="#" style=" border-radius: 20px; !important; font-size: 12px; width: 60px;">Complete</a> <br/>
                        @endif
                        <a class="buttons read_btt" href="{{route('author/book/book_id',['author' =>$books->user->name, 'auhtorId' =>$books->user->id, 'book' =>$books->slug, 'id' => $books->id])}}">Read Book</a>
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
        {{$all_books->links()}}
         
    </div>
    @if($showAds)
         @foreach($bottomAd as $ads)
          {!! $ads->code !!}
        @endforeach
    @endif
        
</div>
   @endsection


  

   
         
