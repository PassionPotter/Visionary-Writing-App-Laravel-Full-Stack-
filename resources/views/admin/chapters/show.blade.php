@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
<div class="card text-center">
    @foreach($chapterContents as $chapterContent)
    <div class="card-header form-control1">
        {{$chapterContent->title}}
    </div>
    <div class="card-body">
        <p class="card-text">{!!$chapterContent->chapter_content!!}</p>
    </div>
    @endforeach
</div>
@endsection