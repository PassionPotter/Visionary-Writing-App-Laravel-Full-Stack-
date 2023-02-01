@extends('admin.layouts.master')
@section('content')

  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <form action="{{route('book/update',['id' =>$Book->id,'status' =>'1'])}}" method="post" enctype="multipart/form-data">
        {!!  csrf_field() !!}
<div class="form-group">
    
    <label for="Book-title">Created Date</label>
    <?php   $abc = date("Y-m-d", strtotime($Book->created_at)); ?>
    <input type="date" name="created_at" class="form-control" id="created_at" value="{{ $abc }}" placeholder="Enter book Date">
  </div>
  
  
  <div class="form-group">
    <label for="Book-title">Title</label>
    <input type="text" name="title" class="form-control" id="title" value="{{$Book->title}}" placeholder="Enter book title">
  </div>
        <div class="form-group">
            <label for="Book-order">Order of Book</label>
            <input type="text" name="bookOrder" class="form-control" value="{{$Book->book_order}}" id="bookOrder" placeholder="Enter book order">
        </div>
    <div class="form-group">
    <input type="hidden" name="status" value="0">
  </div>
        <div class="form-group">
            <label for="bookGenre">Genre</label>
            <select name="bookGenre" id="bookGenre" class="form-control">
                <option value="">Select here</option>
                <option value="Drama"  {{$Book->genre == "Drama"  ? 'selected' : ''}}>Drama</option>
                <option value="Horror" {{$Book->genre == "Horror"  ? 'selected' : ''}}>Horror</option>
                <option value="Romance"  {{$Book->genre == "Romance"  ? 'selected' : ''}}>Romance</option>
                <option value="Thriller"  {{$Book->genre == "Thriller"  ? 'selected' : ''}}>Thriller</option>
                <option value="Science"  {{$Book->genre == "Science"  ? 'selected' : ''}}>Science</option>
                <option value="Fiction"  {{$Book->genre == "Fiction"  ? 'selected' : ''}}>Fiction</option>
                <option value="Poetry" {{$Book->genre == "Poetry"  ? 'selected' : ''}}>Poetry</option>
                <option value="True Story"  {{$Book->genre == "True Story"  ? 'selected' : ''}}>True Story</option>
                <option value="Action"  {{$Book->genre == "Action"  ? 'selected' : ''}}>Action</option>
                <option value="Fantasy"  {{$Book->genre == "Fantasy"  ? 'selected' : ''}}>Fantasy</option>
                <option value="Adult"  {{$Book->genre == "Adult"  ? 'selected' : ''}}>Adult</option>
            </select>
        </div>

  <div class="form-group">
    <label for="bookDescription">Description</label>
    <textarea name="description" class="form-control" id="description" cols="110" rows="10">{{$Book->description}}</textarea>
  </div>
  <div class="form-group">
   @if(Auth::user()->admin)
     <select name="changeAuthor" id="changeAuthor" class="form-control">
       <option> Select an author</option>
            @foreach($all_books as $allusers)
                  <option value="{{$allusers->id}}" {{($Book->user_id ==$allusers->id)?"selected":"" }}>{{$allusers->name}}</option>
             @endforeach
     </select>  
     @endif
     </div>  
  <div class="row">

    <div class="col-md-3">
    <img src="{{asset('public/books/uploads/'.$Book->book_cover)}}" width="60px" height="60px" style="border-radius:50px"id="blah">
    <!-- <img  src="#" alt="your image" /> -->
    <div class="form-group">
    <label for="book_cover">Book cover</label>
    <input type="file" id="book_cover" name="book_cover">
  </div>
  </div>
  </div>
 <div class="row">
   <div class="form-group">
    <div class="col-md-2">
  <button type="submit" class="btn btn-primary">Update</button>
    </div>
     <div class="col-md-2">
   <!-- <a href="#" id="save-book-as-draft" class="btn btn-success">Save to draft </a>   -->
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
        document.getElementById("save-book-as-draft").addEventListener('click', saveBookAsDraft);

        function saveBookAsDraft(e) {
            var book_cover = $('#book_cover').prop('files')[0];
            var title = $('#title').val();
            var bookOrder=$('#bookOrder').val();
            var bookGenre=$('#bookGenre').val();
            var description = $('#description').val();
            var formData = new FormData();
            formData.append('book_cover', book_cover);
            formData.append('title', title);
            formData.append('bookOrder',bookOrder);
            formData.append('bookGenre',bookGenre);
            formData.append('description', description);
            $.ajax({
               // url: "{{route('save_book_as_draft',['status' =>0])}}",
                url: "{{route('update_book_as_draft',['id' =>$Book->id,'status' =>0])}}",
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                   // toastr.success(response.message);
                   location.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON.message = 'The title and content fields can not be left blank');
                }
            });
        }
    });

    $(document).ready(function() {
        $('#description').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['color', ['color']],
                ['height', ['height']]
            ],
            height: 300
        });
    });
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#book_cover").change(function() {
  readURL(this);
});
</script>
@endsection