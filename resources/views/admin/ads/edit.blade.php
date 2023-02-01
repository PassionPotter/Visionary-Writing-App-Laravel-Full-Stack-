@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
         <form action="{{route('update',['id' =>$ad->id])}}" method="post">
            <div class="form-group">
                <?php
                    print_r($ad->type);
                
                ?>
                <label for="adareaplacement">Ad placement</label>
                <select name="adareaplacement" id="adareaplacement" class="form-control">
                    <option value="">Where to place the Ad?</option>
                    <option name="above" value="Top">Above</option>
                    <option name="below" value="Bottom">Below</option>
                    <option name="sidebar" value="sidebar">Side bar</option>
                    <option name="afterTwoBooks" value="afterTwoBooks">After Every Two Books</option>
                    <option name="afterTwoChapters" value="aftertwochapters">After Every Two Chapters</option>
                    <option name="inChapters" value="inChapters">In Chapters</option>
                </select>
            </div>
            <div class="form-group">
                    <label for="adareaplacement">Ad page placement</label>
                    <select name="adpageplacement" id="adpageplacement" class="form-control">
                        <option value="">Which page to place the Ad?</option>
                        <option name="Books" value="Books">Books</option>
                        <option name="Chapters" value="Chapters">Chapters</option>
                        <option name="reading_page" value="reading_page">Reading page</option>
                    </select>
                </div>
                <div class="form-group">
                        <label for="status">status</label>
                        <select name="status" id="status" class="form-control">
                            <option name="active" value="1">Active</option>
                            <option name="inactive" value="0">Inactive</option>
                        </select>
                    </div>
            <div class="form-group">
                <label for="code">Ad code</label>
                <textarea name="code" id="" cols="30" rows="10" class="form-control">{!!  $ad->code  !!}</textarea>
            </div>

            <div class="form-group">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        </div>
    </div>
    
    <script>
        document.getElementById('adpageplacement').value= '{{$ad->page}}';
        document.getElementById('adareaplacement').value= '{{$ad->type}}';
        document.getElementById('status').value= '{{$ad->status}}';
    </script>
    @endsection
 