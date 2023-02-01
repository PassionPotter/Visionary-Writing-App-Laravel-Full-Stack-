@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
         <form action="{{route('store')}}" method="post">
            <div class="form-group">
                <label for="adareaplacement">Ad placement</label>
                <select name="adareaplacement" id="" class="form-control">
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
                    <select name="adpageplacement" id="" class="form-control">
                        <option value="">Which page to place the Ad?</option>
                        <option name="Books" value="Books">Books</option>
                        <option name="Chapters" value="Chapters">Chapters</option>
                        <option name="reading_page" value="reading_page">Reading page</option>
                    </select>
                </div>
            <div class="form-group">
                <label for="code">Ad code</label>
                <textarea name="code" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
    @endsection
 