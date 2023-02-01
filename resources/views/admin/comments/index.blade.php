<?php
function isMobileDevice()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$mobileDetect = isMobileDevice();
?>
@extends('admin.layouts.master')
@section('content')
<script type="text/javascript">
 function changeInAction(){
    $("#applyBtn").show();
}
function selecteRowChecked(){
    
    var selectedOption = $("#selectedAction option:selected").val();
    var comment_ids = [];
    var result = confirm("Want to proceed with "+selectedOption+" Action?");
    if (result) {

       $('input[name="rowChecked"]:checked').each(function(i) {
          comment_ids[i] = this.value;

      });
       var token = '<?php echo csrf_token(); ?>';
       $.ajax({
         method: "get",
         url: "<?php echo url('/'); ?>/delete.multi_comments",
         data: {selectedOption:selectedOption, comment_ids:comment_ids, _token: token}
     }) 
       .done(function( msg ) {
           location.reload();
       });
   }
}
</script>
<div id="page-wrapper">
    @include('admin.errors.errors')
    <div class="graphs">
        <div class="panel panel-default">
            <div class="panel-heading">
                Comments
                <a href="{{URL::to('admin/comments')}}" class="btn btn-sm btn-success">All</a>
                <a href="{{URL::to('admin/comments?page=1&status=1')}}" class="btn btn-sm btn-success">Active</a>
                <a href="{{URL::to('admin/comments?page=1&status=2')}}" class="btn btn-sm btn-warning">Waiting Approval</a>
                <a href="{{URL::to('admin/comments?page=1&status=0')}}" class="btn btn-sm btn-danger">Inactive</a>
            </div>
            <div class="panel-body">
                @if($mobileDetect)
                <div class="responsive-view-list">
                    @if($comments->count() >0)
                    @foreach($comments as $comment)
                    <div class="row comment-row">
                        <div class="col-md-12 col-xs-12">
                            <div class="clearfix">
                                <h5 class="pull-left comment-user"><i class="fa fa-user"></i> {{$comment->user_name}} 
                                    @if($comment->approve == 0)
                                    <span class="label label-warning">Waiting</span>
                                    @elseif($comment->approve == 1)
                                    <span class="label label-success">Approved</span>
                                    @endif
                                </h5>
                                <p class="pull-right comment-email">{{$comment->user_email}}</p>
                            </div>
                            <p class="comment-text">
                                {{$comment->reply_to == 0 ? '' : '<i class="fa fa-reply"></i>'}}
                                {{$comment->comment}}
                            </p>
                            <p class="comment-time">{{date('D, m Y H:i', strtotime($comment->updated_at))}}</p>
                            <div class="comment-actions">
                                @if($comment->reply_to == 0)
                                <a href="{{route('admin.comments.reply',['id' =>$comment->id])}}" class="btn btn-xs btn-primary"><i class="fa fa-comment"></i> Reply</a>
                                @endif
                                <a href="{{route('admin.comments.edit',['id' =>$comment->id])}}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="{{route('admin.comments.delete',['id' =>$comment->id])}}" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="alert alert-dark" role="alert">
                        No comments yet.
                    </div>
                    @endif
                </div>
                @else
                <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-hover">
                        <div>
                            <select id="selectedAction" onchange="changeInAction()">
                                <option>Apply Action</option>
                                <option value="Trash" >Trash</option>
                                <optgroup label="Status">
                                    <option value="Active" >Active</option>
                                    <option value="In-Active" >In-Active</option>
                                    <option value="Waiting-Approval" >Waiting-Approval</option>
                                </optgroup>
                                <optgroup label="Approve">
                                    <option value="Approve">Approve</option>
                                    <option value="Waiting">Waiting</option>
                                </optgroup>    
                            </select>

                            <button class="btn" id="applyBtn" style="display: none;" onclick="selecteRowChecked()">
                                Apply
                            </button>
                        </div>
                        <thead>
                            <th>
                                
                            </th>
                            <th>
                                User name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Comment
                            </th>
                            <th>
                                Book Name
                            </th>
                            <th>
                                Last updated
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Approve
                            </th>
                            <th>
                                Is Reply
                            </th>
                            <th>
                                Actions
                            </th>

                        </thead>
                        <tbody>

                            @if($comments->count() >0)

                            @foreach($comments as $comment)


                            <tr>
                                <td>
                                    <input type="checkbox" name="rowChecked" value="{{$comment->id}}" multiple >
                                    </td>  
                                <td>
                                    {{$comment->user_name}}
                                </td>
                                <td>
                                    {{$comment->user_email}}
                                </td>
                                <td>
                                    {{$comment->comment}}
                                </td>
                                <td>
                                    {{$comment->Chapter->Book->title}}
                                </td>
                                <td>
                                    {{$comment->updated_at}}
                                </td>
                                <td>
                                    @if($comment->status == 0)
                                    <span class="label label-danger">InActive</span>
                                    @elseif($comment->status == 1)
                                    <span class="label label-success">Active</span>
                                    @elseif($comment->status == 2)
                                    <span class="label label-warning">Waiting Approval</span>
                                    @endif
                                </td>
                                <td>
                                    @if($comment->approve == 0)
                                    <span class="label label-danger">Waiting</span>
                                    @elseif($comment->approve == 1)
                                    <span class="label label-success">Approved</span>
                                    @endif
                                </td>
                                <td>
                                    {{$comment->reply_to == 0 ? 'NO' : 'YES'}}
                                </td>
                                <td>
                                    @if($comment->reply_to == 0)
                                    <a href="{{route('admin.comments.reply',['id' =>$comment->id])}}" class="btn btn-xs btn-info">Reply</a>
                                    @endif
                                    <a href="{{route('admin.comments.edit',['id' =>$comment->id])}}" class="btn btn-xs btn-info">Edit</a>
                                    <a href="{{route('admin.comments.delete',['id' =>$comment->id])}}" class="btn btn-xs btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <th colspan="5" class="text-center">No comments yet</th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @endif
                {{ $comments->appends(request()->input())->links() }}
            </div>
        </div>
        @endsection