@extends('admin.layouts.master')
@section('content')
<div id="page-wrapper">
@include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
    <div class="panel-heading"><h2>Edit Comment - <i>{{$chapter->title}}</i></h2></div>
    <div class="panel-body">
   <div class="row">
   <div class="col-sm-6">
   	<div class="">
    
    <form class="form-horizontal"  action="{{route('admin.comments.update',[$comment->id])}}" method="post">
     {!!  csrf_field() !!}
      <input type="hidden" class="form-control" id="chapter_id"  name="chapter_id" value="{{$comment->chapter_id}}">
      <input type="hidden" class="form-control" name="comment_id" value="{{$comment->id}}">
      <div class="">
         <label  for="email">Name:</label> 
          <input type="name" class="form-control" id="name" placeholder="Enter name" required name="name" value="{{$comment->user_name}}" disabled="disabled">
      </div>
       <div class="">
         <label  for="email">Email:</label> 
        
          <input type="email" class="form-control" id="email" placeholder="Enter email" required name="email" value="{{$comment->user_email}}" disabled="disabled">
        
      </div>
      <div class="">
         <label for="comment">Comment:</label> 
        <textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Enter comment" required>{{trim($comment->comment)}}</textarea>
      </div>
       <br>
       <div class="">
         <label  for="email">Change Status:</label> 
         <select class="form-control" name="status">
             <option value="">Select status</option>
             <option value="0" {{ ( $comment->status == 0) ? 'selected' : '' }}>InActive</option>
             <option value="1" {{ ( $comment->status == 1) ? 'selected' : '' }}>Active</option>
             <option value="2" {{ ( $comment->status == 2) ? 'selected' : '' }}>Waiting Approval</option>
         </select>
      </div>
        <div class="">
            <label  for="email">Approve:</label>
            <select class="form-control" name="approve">
                <option value="">Select here</option>
                <option value="0" {{ ( $comment->approve == 0) ? 'selected' : '' }}>Waiting</option>
                <option value="1" {{ ( $comment->approve == 1) ? 'selected' : '' }}>Approve</option>
            </select>
        </div>
      <br>
      <div class="form-group">        
        <!--<div class="col-sm-offset-2 col-sm-10">-->
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Update</button>
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