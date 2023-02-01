@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
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
                        open
                    </th>
                    <th>
                        edit
                    </th>
                    <th>
                        delete
                    </th>
                     <th>
                        status
                    </th>
                </thead>
                <tbody>
                @if(Auth::user()->admin)
                    @foreach($all_books as $Users_book)
                        @foreach($Users_book->books as $books)
                            @if(!$books->status)
                        <tr>   
                        <td>
                        @if($books->book_cover)
                            <img src="{{asset('/books/uploads/').'/'.$books->book_cover}}" width="50px" height="50px">
                         @endif
                            </td>
                            <td>
                                {{$books->title}}
                            </td>
                            <td>
                                {!! $books->description !!}
                            </td>
                              <td>
                                {{$Users_book->name}}
                            </td>
                            <td>
                        <a href="{{route('BookChapters', ['id' => $books->id])}}" class="btn btn-info">View chapters</a>

                            </td> 
                         <td>
                        <a href="{{route('edit.book',['id' =>$books->id])}}" class="btn btn-warning">Edit</a>

                            </td>
                            <td>
                        <a href="{{route('trash.book',['id' =>$books->id])}}" class="btn btn-danger">Trash</a>
                            </td>
                                <td>
                        <a href="{{route('publish.book',['id' =>$books->id,'status' => '1'])}}" class="btn btn-success">Publish</a>
                            </td>
                        </tr>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    @foreach($Users as $user_books)
                    @if(!$user_books->status)
                        <tr>   
                        <td>
                        @if($user_books->book_cover)
                            <img src="/books/uploads/{{$user_books->book_cover}}" width="50px" height="50px">
                          @endif
                            </td>
                            <td>
                                {{$user_books->title}}
                            </td>
                            <td>
                                {!! $user_books->description !!}
                            </td>
                            <td>
                        <a href="{{route('BookChapters', ['id' => $user_books->id])}}" class="btn btn-info">open</a>

                            </td> 
                            <td>
                        <a href="{{route('edit.book',['id' =>$user_books->id])}}" class="btn btn-warning">Edit</button>

                            </td>
                            <td>
                        <a href="{{route('trash.book',['id' =>$user_books->id])}}" class="btn btn-danger">Trash</button>
                            </td>
                           <td>
                        <a href="{{route('publish.book',['id' =>$user_books->id,'status' => '1'])}}" class="btn btn-success">Publish</a>
                            </td>
                        </tr>
                       @endif
                    @endforeach
            @endif
                </tbody>
            </table>
            </div>
        </div>
    </div>
    @endsection