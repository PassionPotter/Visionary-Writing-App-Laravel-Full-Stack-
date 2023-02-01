@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
            <style>
                .btn-success{
                    margin-bottom:15px;
                }
            </style>
            <a href="{{route('viewRlinks')}}" class="btn btn-success">View link restrictions</a>
            <a href="{{route('viewRkeywords')}}" class="btn btn-success">View keyword restrictions</a>
         <h3>Link</h3>
         <form action="{{route('addNewstrict')}}" method="post">
            <div class="form-group">
                <label for="paste_link">Paste link</label>
                <input type="text" name="paste_link" id="paste_link" class="form-control" />
            </div>
            <div class="form-group">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
         <hr />
         <h3>Keyword</h3>
         <form action="{{route('addNewstrictKey')}}" method="post">
            <div class="form-group">
                <label for="keyword">Keyword</label>
                <input type="text" name="keyword" id="keyword" class="form-control" />
            </div>
            <div class="form-group">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
        </div>
    </div>
    @endsection
 