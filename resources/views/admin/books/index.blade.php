<?php
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$mobileDetect = isMobileDevice();
?>
@extends('admin.layouts.master')
@section('content')
<link href="{{asset('css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
 function changeInAction(){
    $("#applyBtn").toggle();
}
function selecteRowChecked(){
    var result = confirm("Want to delete?");
    var bookids = [];
    if (result) {
     $('input[name="rowChecked"]:checked').each(function(i) {
      bookids[i] = this.value;
      
  });
     var token = '<?php echo csrf_token(); ?>';
     $.ajax({
       method: "POST",
       url: "<?php echo url('/'); ?>/admin/trash.books",
       data: { bookids: bookids, _token: token}
   })
     .done(function( msg ) {
         location.reload();
     });
 }
}
function mydel(myId) {


  var txt;
  var r = confirm("Are you sure you want to mark this book as complete!");
  if (r == true) {
    txt = "You pressed OK!";
 //   window.location = "http://visionarywritings.siddhidevelopment.com/admin/trash.book/"+myId;
    window.location = "<?php echo url('/'); ?>/admin/trash.book/"+myId;
//    window.location = "https://visionarywritings.com/admin/trash.book/"+myId;
} else {
    txt = "You pressed Cancel!";
}
document.getElementById("demo").innerHTML = txt;
}


function mydell(myId) {


  var txt;
  var r = confirm("Are you sure you want to unmmark this book as complete");
  if (r == true) {
    txt = "You pressed OK!";
 //   window.location = "http://visionarywritings.siddhidevelopment.com/admin/trash.book/"+myId;
    window.location = "<?php echo url('/'); ?>/admin/trash.unmark/"+myId;
//    window.location = "https://visionarywritings.com/admin/trash.unmark/"+myId;
} else {
    txt = "You pressed Cancel!";
}
document.getElementById("demo").innerHTML = txt;
}

</script>
<div id="page-wrapper">
    @include('admin.errors.errors')
    <div class="graphs">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                Books
                <a href="{{route('book/create')}}" class="btn btn-sm btn-success hidden-md pull-right">Add Book</a>
                <div class="pull-right col-md-3 mobile-mt-10">
                    <form class="input-group" action="" method="get">
                        <input type="text" value="<?= $searchTerm; ?>" name="search_text" class="form-control" />
                        <span class="input-group-btn">
                            <input type="submit" name="search" class="btn btn-primary" />
                            <input type="submit" value="Reset" name="search" class="btn btn-secondary" />
                        </span>
                    </form>
                </div>
            </div>
            <div class="panel-body">
                @if($mobileDetect)
                @if(Auth::user()->admin)
                @foreach($all_books as $books)
                @if($books->status) 
                <div class="responsive-view-list">
                    <div class="row book-row">
                        <div class="col-md-3 col-xs-4 img-container">
                            <?php if($books->book_cover) { ?>
                                <img  src="{{asset('public/books/uploads/').'/'.$books->book_cover}}">
                            <?php }else{ ?>
                                <img src="{{asset('books/uploads/no_image.png')}}"></td>
                            <?php } ?>


                        </div>
                        <div class="col-md-3 col-xs-8">
                            <h5>{{$books->title}}</h5>
                            <a href="{{route('trash.book',['id' =>$books->id])}}" class="btn btn-info btn-block"><i class="fa fa-eye"></i> View Chapters</a>
                            <!-- <a href="{{route('trash.book',['id' =>$books->id])}}" class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i> Move to Trash</a>  -->
                           <!-- <a href="#" onclick="mydel('{{$books->id}}')" class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i> Move to Trashop</a> -->
                           @if($books->complete)
                                     <a href="#" onclick="mydell('{{$books->id}}')" class="btn btn-danger btn-block btn-xs"><i class=""></i> Unmark</a>
                                    @else
                                   <a href="#" onclick="mydel('{{$books->id}}')" class="btn btn-danger btn-block btn-xs"><i class=""></i> mark as complete</a>
                                    @endif
                           
                            @if(!$books->status)

                            <a href="{{route('edit.book',['id' =>$books->id])}}" class="btn btn-secondary btn-block"><i class="fa fa-"></i> Publish</a>                                                        </td>
                            @else
                            <a href="{{route('trash.book',['id' =>$books->id])}}" class="btn btn-success btn-block"><i class="fa fa-file"></i> Save to Draft</a>
                            @endif

                            <a href="{{route('edit.book',['id' =>$books->id])}}" class="btn btn-warning btn-block"><i class="fa fa-pencil"></i> Edit Book</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @if(Auth::user()->admin)
                {{$all_books->links()}}
                @else
                {{$Users->links()}}
                @endif
                @else
                @foreach($Users as $user_books)
                @if($user_books->status)
                <div class="responsive-view-list">
                    <div class="row book-row">
                        <div class="col-md-3 col-xs-4 img-container">
                            @if($user_books->book_cover)
                            <img src="{{asset('public/books/uploads/').'/'.$user_books->book_cover}}">
                            @endif
                        </div>
                        <div class="col-md-3 col-xs-8">
                            <h5>{{$user_books->title}}</h5>
                            <a href="{{route('BookChapters', ['id' => $user_books->id])}}" class="btn btn-info btn-block btn-xs"><i class="fa fa-eye"></i> View Chapters</a>
                            <!-- <a href="{{route('trash.book',['id' =>$user_books->id])}}" class="btn btn-danger btn-block btn-xs"><i class="fa fa-trash-o"></i> Move to Trash</a> -->
                           <!-- <a href="#" onclick="mydel('{{$user_books->id}}')" class="btn btn-danger btn-block btn-xs"><i class="fa fa-trash-o"></i> Move to Trashiu</a> -->
                             @if($user_books->complete)
                                     <a href="#" onclick="mydell('{{$user_books->id}}')" class="btn btn-danger btn-block btn-xs"><i class=""></i> Unmark</a>
                                    @else
                                   <a href="#" onclick="mydel('{{$user_books->id}}')" class="btn btn-danger btn-block btn-xs"><i class=""></i> mark as complete</a>
                                    @endif
                            @if(!$user_books->status)
                            <a href="{{route('edit.book',['id' =>$user_books->id])}}" class="btn btn-secondary btn-block btn-xs"><i class="fa fa-"></i> Publish</a>
                            @else
                            <a href="{{route('chapter/create',['book' =>$user_books->id])}}" class="btn btn-success btn-block btn-xs"><i class="fa fa-file"></i> Add Chapter</a>
                            @endif
                            <a href="{{route('edit.book',['id' =>$user_books->id])}}" class="btn btn-warning btn-block btn-xs"><i class="fa fa-pencil"></i> Edit Book</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endif
                @if(Auth::user()->admin)
                  <!--   {{$all_books->links()}} -->
                    @else
                    {{$Users->links()}}
                    @endif
                <!-- FOR WEBVIEW -->
                @else
                <div class="web-view-list">
                    <div class="table-responsive" data-pattern="priority-columns"> 
                        <table class="table table-small-font table-hover">
                            <div>
                                <select id="selectedAction" onchange="changeInAction()">
                                    <option>Apply Action</option>
                                    <option>Trash</option>
                                </select>
                                
                                <button class="btn" id="applyBtn" style="display: none;" onclick="selecteRowChecked()">
                                    Apply
                                </button>
                            </div>
                            <thead>
                                <th></th>
                                <th>image</th>
                                <th>title</th>
                                <th>genre</th>
                                <th>order</th>
                                
                                @if(Auth::user()->admin)
                                <th>Author</th>
                                @endif
                                <th>open</th>
                                <th>Chapters</th>
                                <th>edit</th>
                                <th>status</th>
                                 <th>mark complete/unmark</th>
                               <!-- <th>delete</th>-->
                                <th> created_at</th>
                            </thead>
                            <tbody>
                                @if(Auth::user()->admin)
                                @foreach($all_books as $books)
                                @if($books->status) 
                                <tr>
                                    <td>
                                        <input type="checkbox" name="rowChecked" value="{{$books->id}}" multiple >
                                    </td>   
                                    <td>
                                        <?php if($books->book_cover) { ?>
                                            <img src="{{asset('public/books/uploads/').'/'.$books->book_cover}}" width="50px" height="50px">
                                        <?php }else{ ?>
                                            <img src="{{asset('books/uploads/no_image.png')}}" width="50px" height="50px"></td>
                                        <?php } ?>
                                    </td>
                                    <td>{{$books->title}}</td>
                                    <td>{{$books->genre ? $books->genre : 'N/A'}}</td>
                                    <td>{{$books->book_order}}</td>
                                    
                                    <td>
                                        @if($books->user && $books->user->name )
                                        {{$books->user->name}}
                                        @endif
                                    </td>
                                    <td><a href="{{route('BookChapters', ['id' => $books->id])}}" class="btn btn-info">View chapters</a></td> 
                                    <td>{{$books->Chapters()->count()}}</td>
                                    <td><a href="{{route('edit.book',['id' =>$books->id])}}" class="btn btn-warning">Edit</a></td>
                                    <input type="hidden" >
                                    @if(!$books->status)
                                    <td>
                                        <a href="{{route('edit.book',['id' =>$books->id])}}" class="btn btn-secondary">Publish</a>
                                    </td>
                                    @else
                                    <td><!-- <a href="{{route('save_published_book_as_draft',['id' =>$books->id, 'status' => '0'])}}" class="btn btn-success">To save to draft</a> --></td>
                                    @endif
                                    <!--  <td><a href="{{route('trash.book',['id' =>$books->id])}}" class="btn btn-danger">Trash</a></td> -->
                                    <!-- <td><a href="#" onclick="mydel('{{$books->id}}')" class="btn btn-danger">Trash</a></td> -->
                                    <td>
                                     @if($books->complete)
                                     <a href="#" onclick="mydell('{{$books->id}}')" class="btn btn-danger btn-block"><i class=""></i> Unmark</a>
                                    @else
                                   <a href="#" onclick="mydel('{{$books->id}}')" class="btn btn-danger btn-block"><i class=""></i> mark as complete</a>
                                    @endif
                                   </td>
                                    <td>{{$books->created_at->diffForHumans()}}</td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                @foreach($Users as $user_books)
                                @if($user_books->status)
                                <tr>   
                                    <td>
                                        @if($user_books->book_cover)
                                        <img src="{{asset('public/books/uploads/').'/'.$user_books->book_cover}}" width="50px" height="50px">
                                        @else
                                        <img src="{{asset('books/uploads/no_image.png')}}" width="50px" height="50px"></td>
                                        @endif
                                    </td>
                                    <td>{{$user_books->title}}</td>
                                    <td>{{$user_books->genre ? $user_books->genre : 'N/A'}}</td>
                                    <td>{{$user_books->book_order}}</td>
                                    <td>{!! $user_books->description !!}</td>
                                    <td>
                                        <a href="{{route('BookChapters', ['id' => $user_books->id])}}" class="btn btn-info">View chapters</a>
                                    </td> 
                                    <td>{{$user_books->Chapters()->count()}}<td>
                                        <a href="{{route('edit.book',['id' =>$user_books->id])}}" class="btn btn-warning">Edit</a>
                                    </td>@if(!$user_books->status) <td>
                                        <a href="{{route('edit.book',['id' =>$user_books->id])}}" class="btn btn-secondary">Publish</a>
                                    </td>@else<td>
                                        <a href="{{route('save_published_book_as_draft',['id' =>$user_books->id, 'status' => '0'])}}" class="btn btn-success">To save to draft</a>
                                    </td>@endif<td>
                                       <!-- <a href="{{route('trash.book',['id' =>$user_books->id])}}" class="btn btn-danger">Trash</a>-->
                                        @if($user_books->complete)
                                     <a href="#" onclick="mydell('{{$user_books->id}}')" class="btn btn-danger btn-block"><i class=""></i> Unmark</a>
                                    @else
                                   <a href="#" onclick="mydel('{{$user_books->id}}')" class="btn btn-danger btn-block"><i class=""></i> mark as complete</a>
                                    @endif
                                    </td>
                                      
                                    <td>
                                        {{$user_books->created_at->diffForHumans()}}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(Auth::user()->admin)
                    {{$all_books->links()}}
                    @else
                    {{$Users->links()}}
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection
