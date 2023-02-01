
@extends('frontend.layouts.master')
@section('content')

<style type="text/css">
  .book_col .book_image img{width: auto !important;max-height: 130px !important; }
</style>

 <div class="container"  style="padding-top:90px">
    @if($query !==null && $query!=='Search')
   
    <?php if(count($books)>0){ ?>
    <h3 style=' font-weight: 800; font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; color: #2079ca; '>Search result Books</h3>
   @foreach($books->chunk(3) as $book)
   
   <div class="row">
      @foreach($book as $book_chapter)
      <div class="col-md-4">
       <div class="book_col clearfix">
              <div class="book_image" style=" float: none; ">
                  <div>
                    @if($book_chapter->book_cover && file_exists(public_path('books/uploads/T-'.$book_chapter->book_cover)))
                    <img src="{{asset('public/books/uploads/T-'.$book_chapter->book_cover)}}" alt="" >
                    @elseif($book_chapter->book_cover && file_exists(public_path('books/uploads/T-'.$book_chapter->book_cover)))
                    <img src="{{asset('public/books/uploads/'.$book_chapter->book_cover)}}" alt="" >
                    @else
                    <img src="{{asset('public/images/T-no_image.png')}}" alt="" style=" width: 100%; ">
                     @endif
                  </div>
              </div>
                <div class="book_details">
                  <h3>{{addslashes($book_chapter->title)}}</h3>
                  
                    <p><span>Views:</span>{{addslashes($book_chapter->views)}}</p>
                    @isset($book_chapter->user->name)
                    <a class="buttons read_btt" href="{{route('author/book/book_id',['author' =>$book_chapter->user->name, 'auhtorId' =>$book_chapter->user->id, 'book'=>str_replace('?','',$book_chapter->slug), 'id' => $book_chapter->id])}}">Read Book</a>
                    @endisset
                </div>
            </div>
          
           
     </div>
     @endforeach
     </div>
   @endforeach
   <?php } ?>
   <hr>
   <div class="row">
   <?php if(count($authors)>0){ ?>
    <h3 style=' font-weight: 800; font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; color: #2079ca; '>Search result Author</h3>
      @foreach($authors as $author)
      
        @if($author->profile)
          <div class="col-md-4">
          <div class="book_col clearfix">
              <div class="book_image" style=" float: none; ">
                  <div>
                  @if($author->profile->avatar && file_exists(public_path('books/avatars/'.$author->profile->avatar)))
                   <img src="{{asset('public/books/avatars/'.$author->profile->avatar)}}" />
                    @else
                    <img src="{{asset('public/books/avatars/avatar.png')}}" style=" width: 100%; ">
                     @endif
                  </div>
              </div>
                <div class="book_details">
                  <h3>{{addslashes($author->name)}}</h3>
                    
                    <p><span>Views:</span>{{$author->views}}</p>
                    <a class="buttons read_btt" href="{{route('author/books/author_id',['author' =>$author->name, 'id' => $author->id])}}">Read Book</a>
                </div>
            </div>
            
     </div>
     @endif
     @endforeach
     <?php } ?>
     </div>
   @else
   <h3>WE BELIEVE YOU HAVE HIT ROCK BOTTOM, DID MISSTYPE SOMETHING?</h3>
   @endif
   {{-- @if($query!==null)
   {{$chapters->links()}}
   @endif --}}
          <nav>
            <ul class="pager">
            </ul>
          </nav>

    </div><!-- /.container -->
@endsection