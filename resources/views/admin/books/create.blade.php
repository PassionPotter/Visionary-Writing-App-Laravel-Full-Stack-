@extends('admin.layouts.master')
@section('content')
<link href="{{asset('css/new.css')}}" rel="stylesheet" type="text/css" media="all" />
<link href="{{asset('css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <form action="{{route('book/store',['status' =>'1'])}}" method="post" enctype="multipart/form-data">
        {!!  csrf_field() !!}
  <div class="form-group">
    <div class="form-group">
      <label for="book_cover">Book cover</label>
      <div class="row">
        <div class="col-sm-12 col-md-12">
          <div class="cover-container" >
            <img  src="{{url('/images/book-placeholder.png')}}" id="preview" class="rounded float-left"  >
          </div>
        </div>
        <div class="col-sm-12 col-md-12">
          <input type="file" class="add-book-cover" id="book_cover" name="book_cover">
        </div>
      </div>
    </div> 
    <label for="Book-title">Title</label>
    <input type="text" name="title" class="form-control" id="title" aria-describedby="bookTitle" placeholder="Enter book title">
  </div>
        <div class="form-group">
            <label for="Book-order">Order of Book</label>
            <input type="text" name="bookOrder" class="form-control" id="bookOrder" placeholder="Enter book order">
        </div>
    <div class="form-group">
    <input type="hidden" name="status" value="0">
  </div>
        <div class="form-group">
            <label for="Book-Genre">Genre</label>
            <select name="bookGenre" id="bookGenre" class="form-control">
                <option value="">Select here</option>
                <option value="Drama">Drama</option>
                <option value="Horror">Horror</option>
                <option value="Romance">Romance</option>
                <option value="Thriller">Thriller</option>
                <option value="Science">Science</option>
                <option value="Fiction">Fiction</option>
                <option value="Poetry">Poetry</option>
                <option value="True Story">True Story</option>
                <option value="Action">Action</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Adult">Adult</option>
            </select>
        </div>

  <div class="form-group">
    <label for="bookDescription">Book description</label>
    <textarea name="description" class="form-control" id="description"></textarea>
  </div>

  <div class="form-group">
  <button type="submit" class="btn btn-primary">Publish</button>
   <!-- <a href="#" id="save-book-as-draft" class="btn btn-secondary">Save to draft</a> -->
   	@if(Auth::user()->admin)
        <select name="changeAuthor" id="changeAuthor" class="form-control">
            @foreach($all_books as $allusers)
            `	@if($allusers->active)
                  <option value="{{$allusers->id}}" id="changeAuthor">{{$allusers->name}}</option>
                 @endif
             @endforeach
     </select>  
     @endif
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
      // document.getElementById("save-book-as-draft").addEventListener('click',displayModal);
       document.getElementById("changeAuthor").addEventListener('click',changeAuthor);
       let getAuthorId;
       function changeAuthor(e)
       {
         if(e.target.id==="changeAuthor")
         {
           getAuthorId =e.target.value;
         }
       }
        function displayModal(e){
          var book_cover = $('#book_cover').prop('files')[0];
          var title=$('#title').val();
          var bookGenre=$('#bookGenre').val();
          var bookOrder=$('#bookOrder').val();
          var description=$('#description').val();
          var formData = new FormData()
          formData.append('book_cover',book_cover);
          formData.append('title',title);
          formData.append('bookOrder',bookOrder);
          formData.append('bookGenre',bookGenre);
          formData.append('description',description);
          formData.append('changeAuthor',getAuthorId);
            $.ajax({
              url:"{{route('save_book_as_draft',['status' =>0])}}",
              type:"post",
              data:formData,
             processData: false,
            contentType: false,
          success: function(response){
            toastr.success(response.message ="Book successfuly saved to draft");
          },
          error:function(err){
            console.log(err);
            toastr.error(err.responseJSON.message= "Book title can not be left blank" );
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
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']]
    ],
      height: 300
    });
  });

  function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#book_cover").change(function() {
  readURL(this);
});
</script>
@endsection