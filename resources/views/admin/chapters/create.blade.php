@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <form action="{{route('chapter/store')}}" method="post">
        {!!  csrf_field() !!}
        <div class="form-group">
        <label for="Book-title">Book</label>
    <select class="form-control" name="bookId" id="book_id">
        <option>select a book</option>
        <!-- @if(Auth::user()->admin)
          @foreach($all_authors_books as $author_books)
          @foreach($author_books->books as $books)
            <option value="{{$books->id}}" id="book_id">{{$books->title}}</option>
          @endforeach
          @endforeach
        @else 
        @foreach($books as $book)
        <option value="{{$book->id}}" id="book_id">{{$book->title}}</option>
        @endforeach
        @endif -->

        die(var_dump('far'));
        @if(Auth::user()->admin)
        @foreach($all_books as $books)
            <option value="{{$books->id}}" id="book_id">{{$books->title}}</option>
          @endforeach
          @else

          @foreach($user_books as $books)
            <option value="{{$books->id}}" @if($books->id == $book_id ) selected="selected" @endif  id="book_id">
              {{$books->title}}
 
            </option>
          @endforeach

          @endif
    </select>
   </div>
  <div class="form-group">
    <label for="Book-title">Chapter</label>
    <input type="text" name="title" class="form-control" id="title" aria-describedby="bookTitle" placeholder="Enter chapter title">
</div>
  <div class="form-group">
    <label for="chapter_content">chapter content</label>
    <textarea name="chapter_content" class="form-control" id="chapter_content" cols="110" rows="10"></textarea>
  </div>

  <div class="form-group">
  <div class="row">
    <div class="col-md-2">
  <button type="submit" class="btn btn-primary">Publish</button>
  </div>
  <div class="col-md-2">
    <!-- <a href="#" type="submit" id="save-draft" class="btn btn-secondary">Save to draft</a> -->
    </div>
    <div class="col-md-1">
    <input type="file" name="import-users" id="chapterFile">
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
    <a href="#" class="btn btn-primary" id="Importchapters">Import chapters</a>
    </div>
  </div>
  </div>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
   $(document).ready(function() {
      document.getElementById("save-draft").addEventListener('click',displayModal);
      document.getElementById("book_id").addEventListener("click",BookId);
      let book_id;
        function BookId(e)
        {
               if(e.target.id ==="book_id")
                  {
                  book_id = e.target.value;
        }
      }
        let title;
        let chapter_content;
        function displayModal(e){
            title = $('#title').val();
            chapter_content = $('#chapter_content').val();
            $.ajax({
              url:"{{route('chapter/draft')}}",
              type:"get",
              data: {
                title:title, chapter_content:chapter_content,book_id:book_id
          },
          success: function(response)
          {
          
            toastr.success(response.message);
          },
          error:function(err)
          {
            toastr.error(err.responseJSON.message = 'The title and content fields can not be left blank');
          }
    });
      }
       });
</script>

<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
   $(document).ready(function() {
      document.getElementById("Importchapters").addEventListener('click',importUsers);
        document.getElementById("book_id").addEventListener("click",BookId);
        let book_id;
        function BookId(e)
        {
               if(e.target.id ==="book_id")
                  {
                  book_id = e.target.value;
        }
      }
        function importUsers(e){
        var chaptersFile = $('#chapterFile').prop('files')[0];
          var formData = new FormData();
          formData.append('chaptersFile',chaptersFile);
          formData.append('book_id',book_id);
            $.ajax({
              url:"{{route('chapters.import')}}",
              type:"post",
              data:formData,
             processData: false,
            contentType: false,
          success: function(response){
            toastr.success(reponse);
          },
          error:function(err){
              console.log(err);
                toastr.error("Errors while importing users! did you import a file?");
          }
      });
       }
    });
       $(document).ready(function() {
  $('#chapter_content').summernote({
      toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough']],
    ['fontsize', ['fontsize']],
    ['para', ['ul', 'ol', 'paragraph']],
   // ['color', ['color']],
    ['height', ['height']]
  ],
    height: 300
  });
});

</script>
@endsection