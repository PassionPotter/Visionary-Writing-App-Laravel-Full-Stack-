<?php
use Illuminate\Support\Str;
function isMobileDevice()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$mobileDetect = isMobileDevice();
?>
@extends('admin.layouts.master')
@section('content')
<div id="page-wrapper">
    <link href="{{asset('css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
    @include('admin.errors.errors')

    <div class="graphs">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($mobileDetect)
                    @if(Auth::user()->admin)
                        @if(count($all_books)>0)
                            @foreach($all_books as $Users_book)
                            <div class="responsive-view-list">
                                <div class="row book-row">
                                    <div class="col-md-3 col-xs-4 img-container">
                                        <?php if ($Users_book->book_cover) { ?>
                                            <img src="{{asset('public/books/uploads/').'/'.$Users_book->book_cover}}">
                                        <?php } else { ?>
                                            <img src="{{asset('books/uploads/no_image.png')}}"></td>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-3 col-xs-8">
                                        <h5 class="book-title">{{$Users_book->title}}</h5>
                                        <p class="book-author">
                                            @isset($user_books->user->name)
                                            {{ addslashes($user_books->user->name) }}
                                            @else
                                             Not Set   
                                            @endif
                                        </p>
                                        <div class="book-content">
                                            {!! Str::limit(addslashes($Users_book->description), 50, '...') !!}
                                        </div>
                                        <a href="{{route('restore.trashed.book',['id' =>$Users_book->id])}}" class="btn btn-success btn-xs">Restore</a>
                                        <a href="{{route('delete.trashed.book',['id' =>$Users_book->id])}}" class="btn btn-danger btn-xs">Delete </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    @else
                        @if(count($Users)>0)
                            @foreach($Users as $user_books)
                            <div class="responsive-view-list">
                                <div class="row book-row">
                                    <div class="col-md-3 col-xs-4 img-container">
                                        <?php if ($user_books->book_cover) { ?>
                                            <img src="{{asset('public/books/uploads/').'/'.$user_books->book_cover}}">
                                        <?php } else { ?>
                                            <img src="{{asset('/books/uploads/no_image.png')}}"></td>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-3 col-xs-8">
                                        <h5 class="book-title">{{$user_books->title}}</h5>
                                        <p class="book-author">@isset($user_books->user->name)
                                            {{ addslashes($user_books->user->name) }}
                                            @else
                                             Not Set   
                                            @endif</p>
                                        <div class="book-content">
                                            {!! Str::limit(addslashes($user_books->description), 50, '...') !!}
                                        </div>
                                        <a href="{{route('restore.trashed.book',['id' =>$user_books->id])}}" class="btn btn-success btn-xs">Restore</a>
                                        <a href="{{route('delete.trashed.book',['id' =>$user_books->id])}}" class="btn btn-danger btn-xs">Delete </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    @endif
                @else
                <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-small-font table-hover">
                        <thead>
                            <th>
                                image
                            </th>
                            <th>
                                title
                            </th>
                            <th>
                                description
                            </th>
                            @if(Auth::user()->admin)
                            <th>
                                Author
                            </th>
                            @endif
                            <th>
                                Restore
                            </th>
                            <th>
                                delete permanetely
                            </th>
                        </thead>
                        <tbody>
                            @if(Auth::user()->admin)
                            @if(count($all_books)>0)
                            @foreach($all_books as $Users_book)
                            <tr>
                                <td>
                                    @if($Users_book->book_cover)
                                    <img src="{{asset('/books/uploads/').'/'.$Users_book->book_cover}}" width="50px" height="50px">
                                    @endif
                                </td>
                                <td>
                                    {{ addslashes($Users_book->title) }}
                                </td>
                                <td>
                                    {!! addslashes($Users_book->description) !!}
                                </td>
                                <td>
                                    @isset($Users_book->user->name)

                                            {{ addslashes($Users_book->user->name) }}
                                            @else
                                             Not Set   
                                            @endif
                                </td>
                                <td>
                                    <a href="{{route('restore.trashed.book',['id' =>$Users_book->id])}}" class="btn btn-success">Restore</a>

                                </td>
                                <td>
                                    <a href="{{route('delete.trashed.book',['id' =>$Users_book->id])}}" class="btn btn-danger">Delete </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @else

                            @if(count($Users)>0)

                            @foreach($Users as $user_books)

                            <tr>
                                <td>
                                    @if($user_books->book_cover)
                                    <img src="/books/uploads/{{$user_books->book_cover}}" width="50px" height="50px">
                                    @endif
                                </td>
                                <td>
                                    {{ addslashes($user_books->title) }}
                                </td>
                                <td>
                                    {!! addslashes($user_books->description) !!}
                                </td>
                                <td>
                                    <a href="{{route('restore.trashed.book',['id' =>$user_books->id])}}" class="btn btn-success">Restore</a>

                                </td>
                                <td>
                                    <a href="{{route('delete.trashed.book',['id' =>$user_books->id])}}" class="btn btn-danger">Delete </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @endif
                        </tbody>
                    </table>

                </div>

                @endif
            </div>
        </div>
    </div>
</div>
@endsection