@extends('frontend.layouts.master')
@section('content')
<style>
  .comment-reply{

    display: none;
  }
  .row{
-webkit-user-select: none; /*(Chrome/Safari/Opera)*/
/*-webkit-touch-callout: none;*/
-moz-user-select: none;/*(Firefox)*/
-ms-user-select: none;/*(IE/Edge)*/
-*-user-select: none;
-khtml-user-select: none;
 user-select: none;

}
</style>
<div class="container" style="padding-top:90px">
@if(Session::has('success'))
  <div class="alert alert-success alert-block">
    {{session('success')}}
  </div>
@endif

<div class="row">
   <div class="col-sm-6">
   	<div class="a_comment_form_area">
    <h2>Update your opinion - <i>{{$chapter->title}}</i></h2>
    <form class="form-horizontal"  action="{{route('comment/update',[$comment->id,$comment->chapter_id])}}" method="post">
     {!!  csrf_field() !!}
      <input type="hidden" class="form-control" id="chapter_id"  name="chapter_id" value="{{$comment->chapter_id}}">
      <input type="hidden" class="form-control" name="comment_id" value="{{$comment->id}}">
      <div class="form-group">
       <!--  <label  for="email">Email:</label> -->
        
          <input type="name" class="form-control" id="name" placeholder="Enter name" required name="name" value="{{$comment->user_name}}" disabled="disabled">
        
      </div>
       <div class="form-group">
       <!--  <label  for="email">Email:</label> -->
        
          <input type="email" class="form-control" id="email" placeholder="Enter email" required name="email" value="{{$comment->user_email}}" disabled="disabled">
        
      </div>
      <div class="form-group">
        <!-- label for="comment">Comment:</label> -->
        <textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Enter comment" required>{{trim($comment->comment)}}</textarea>
      </div>
      
      <div class="form-group">        
        <!--<div class="col-sm-offset-2 col-sm-10">-->
        <div>
          <button type="submit" class="btn btn-default">Update</button>
        </div>
      </div>
    </form>
	</div>

    </div>
    </div>

</div>
@endsection