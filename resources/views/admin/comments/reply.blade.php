@extends('admin.layouts.master')
@section('content')
<div id="page-wrapper">
@include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
    <div class="panel-heading"><h4>Reply to Comment: Chapter: <i>{{$chapter->title}}</i></h4></div>
    <div class="panel-body">
   <div class="row">
   <div class="col-sm-6">
   	<div class="">
    
    <form class="form-horizontal"  action="{{route('admin.comments.reply.create',[$comment->id])}}" method="post">
     {!!  csrf_field() !!}
      <input type="hidden" class="form-control" id="chapter_id"  name="chapter_id" value="{{$comment->chapter_id}}">
      <input type="hidden" class="form-control" name="comment_id" value="{{$comment->id}}">
      <div class="">
         <label  for="email">Name: {{$comment->user_name}} </label>  <label  for="email">Email: {{$comment->user_email}} </label> 
      </div>
      <div class="">
         <label for="comment">Comment:</label> 
        <textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Enter comment" disabled="disabled">{{trim($comment->comment)}}</textarea>
      </div>
       <br>
      <div class="">
         <label for="comment">Reply to Comment:</label> 
        <textarea class="form-control" name="reply" rows="5" placeholder="Enter reply"></textarea>
      </div>
      <br>
      <div class="form-group">        
        <!--<div class="col-sm-offset-2 col-sm-10">-->
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Add Reply</button>
        </div>
      </div>
    </form>
	</div>

    </div>
    </div>
    </div>
</div>
</div>
</div>
@endsection