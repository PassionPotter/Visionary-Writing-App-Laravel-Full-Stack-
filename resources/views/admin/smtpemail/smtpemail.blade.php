@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-heading">
            SMTP Email Setting
        </div>
        <div class="panel-body">
            <form action="{{route('smtpemailupdate')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">MAIL DRIVER</label>
                    <input class="form-control" type="text" value="{{$smtpemail->MAIL_DRIVER}}" placeholder="MAIL DRIVER" readonly>
                </div>
                 <div class="form-group">
                    <label for="name">MAIL HOST</label>
                    <input type="text" name="MAIL_HOST" class="form-control" value="{{$smtpemail->MAIL_HOST}}">
                </div>
                 <div class="form-group">
                    <label for="name">MAIL PORT</label>
                    <input type="text" name="MAIL_PORT" class="form-control" value="{{$smtpemail->MAIL_PORT}}">
                </div>
                 <div class="form-group">
                    <label for="name">MAIL USERNAME</label>
                    <input type="text" name="MAIL_USERNAME" class="form-control" value="{{$smtpemail->MAIL_USERNAME}}">
                </div>
                 <div class="form-group">
                    <label for="name">MAIL PASSWORD</label>
                    <input type="text" name="MAIL_PASSWORD" class="form-control" value="{{$smtpemail->MAIL_PASSWORD}}">
                </div>
                 <div class="form-group">
                    <label for="name">MAIL FROM ADDRESS</label>
                    <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" value="{{$smtpemail->MAIL_FROM_ADDRESS}}">
                </div>                                
                <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                <button class="btn btn-success" type="submit">Save</button>
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