@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-heading">
            Send Email
        </div>
        <div class="panel-body">
            <form action="{{route('send_mail1')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="subject_mail"> Subject : </label>
                    <input type="text" value="" checked id="subject_mail" name="subject_mail" class="form-control" placeholder="Subject">
                </div>
                <div class="form-group">
                    <label for="message_mail"> Message : </label>
                    <textarea rows="10" name="message_mail" id ="message_mail" class="form-control" placeholder="Enter your message..."></textarea>
                </div>                
                <div class="form-group">
                    <input type="checkbox" value="1" checked  name="reader_mail[]">
                    <label for="reader_mail"> All Reader</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" value="0" checked name="reader_mail[]">
                    <label for="author_mail"> All Author</label>
                </div>
                          
                <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                <button class="btn btn-success" type="submit">Send Mail</button>
                    </div>
                </div>
                </div>
                </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$(document).ready(function() {

});
</script>
@endsection