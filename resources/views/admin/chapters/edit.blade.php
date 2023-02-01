@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
  @include('admin.errors.errors')
  <div class="panel panel-default">
      <div class="panel-heading">
          Update chapter: {{$chapter->title}}
      </div>
    <div class="panel-body">
    <form action="{{route('update.chapter',['id'=>$chapter->id])}}" method="post">
        {!!  csrf_field() !!}
  <div class="form-group">
    <label for="Book-title" class="col-sm-2 control-label">Title</label>
    <input type="text" name="title" class="form-control" id="title" value="{{$chapter->title}}" aria-describedby="bookTitle" placeholder="Enter chapter title">
  </div>
  <div class="form-group">
    <label for="title" class="col-sm-2 control-label">Chapter content</label>
    <textarea class="form-control1" name="chapter_content" id="chapter_content" cols="110" rows="10">{{$chapter->chapter_content}}</textarea>
  </div>
    <div class="form-group">
    <label for="Book-title" class="col-sm-2 control-label">Date</label>
    <input type="text" name="created_at" class="form-control1" id="created_at" value="{{$chapter->created_at}}" aria-describedby="bookTitle" placeholder="Enter chapter title">
  </div>
  <div class="form-group">
  <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
</div>
  </div>
@endsection

@section('scripts')
<script>
       $(document).ready(function() {
  $('#chapter_content').summernote({
      toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough']],
    ['fontsize', ['fontsize']],
    ['para', ['ul', 'ol', 'paragraph']],
    //['color', ['color']],
    ['height', ['height']]
  ],
    height: 300
  });
});

</script>
@endsection