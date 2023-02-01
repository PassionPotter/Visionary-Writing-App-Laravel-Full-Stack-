<?php

use Illuminate\Support\Str;

function isMobileDevice()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$mobileDetect = isMobileDevice();
?>
@extends('admin.layouts.master')
@section('content')
<div id="page-wrapper">
    @include('admin.errors.errors')
    <div class="graphs">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($mobileDetect)
                <div class="responsive-view-list">
                    @foreach($chapters as $chapter)
                    @if(!$chapter->status)
                    <div class="comment-row">
                        <div class="row">
                            <div class="col-md-3 col-xs-7">
                                <h5 class="book-title">{{$chapter->title}}</h5>
                                <p class="book-author">Created {{date('m j, y',strtotime($chapter->created_at))}}</p>
                                <p class="book-author">Updated {{date('m j, y',strtotime($chapter->updated_at))}}</p>
                            </div>
                            <div class="col-xs-5">
                                
                                
                                <a href="{{route('edit.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-warning">Edit</a>
                                
                                <a href="{{route('delete.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-danger">Delete</a>
                                
                                <a href="{{route('publish.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-secondary">Publish</a>
                            </div>
                        </div>
                        <a href="{{route('read.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-block btn-primary mobile-mt-10">Read</a>
                        
                    </div>
                    @else
                    <div class="comment-row">
                        <div class="row">
                            <div class="col-md-3 col-xs-7">
                                <h5 class="book-title">{{$chapter->title}}</h5>
                                <p class="book-author">Created {{date('m j, y',strtotime($chapter->created_at))}}</p>
                                <p class="book-author">Updated {{date('m j, y',strtotime($chapter->updated_at))}}</p>
                            </div>
                            <div class="col-xs-5">
                                <a href="{{route('edit.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-warning">Edit</a>
                                
                                <a href="{{route('delete.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-danger">Delete</a>
                                
                                <!-- <a href="{{route('draft.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-success btn-block mobile-mt-10">Save to Draft</a> -->
                            </div>
                        </div>
                        <a href="{{route('read.chapter',['id' =>$chapter->id])}}" class="btn btn-xs btn-primary btn-block mobile-mt-10">Read</a>
                    </div>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-small-font table-hover">
                        <thead>
                            <th>
                                Title
                            </th>
                            <th>
                                Read
                            </th>
                            <th>
                                Edit
                            </th>
                            <th>
                                Delete
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Created_at
                            </th>
                            <th>
                                Modified on
                            </th>
                        </thead>
                        <tbody>
                            @foreach($chapters as $chapter)
                            @if(!$chapter->status)
                            <tr>
                                <td>
                                    {{$chapter->title}}
                                </td>
                                <td>
                                    <a href="{{route('read.chapter',['id' =>$chapter->id])}}" class="btn btn-primary">Read</a>

                                </td>
                                <td>
                                    <a href="{{route('edit.chapter',['id' =>$chapter->id])}}" class="btn btn-warning">Edit</a>

                                </td>
                                <td>
                                    <a href="{{route('delete.chapter',['id' =>$chapter->id])}}" class="btn btn-danger">Delete</a>
                                </td>
                                <td>
                                    <a href="{{route('publish.chapter',['id' =>$chapter->id])}}" class="btn btn-secondary">Publish</a>
                                </td>
                                <td>
                                    {{date('m j, y',strtotime($chapter->created_at))}}
                                </td>
                                <td>
                                    {{date('m j, y',strtotime($chapter->updated_at))}}
                                </td>
                            </tr>
                            @else

                            <tr>
                                <td>
                                    {{$chapter->title}}
                                </td>
                                <td>
                                    <a href="{{route('read.chapter',['id' =>$chapter->id])}}" class="btn btn-primary">Read</a>

                                </td>
                                <td>
                                    <a href="{{route('edit.chapter',['id' =>$chapter->id])}}" class="btn btn-warning">Edit</a>

                                </td>
                                <td>
                                    <a href="{{route('delete.chapter',['id' =>$chapter->id])}}" class="btn btn-danger">Delete</a>
                                </td>
                                <td>
                                    <!-- <a href="{{route('draft.chapter',['id' =>$chapter->id])}}" class="btn btn-success">Save to Draft</a> -->
                                </td>
                                <td>
                                    {{date('m j, y',strtotime($chapter->created_at))}}
                                </td>
                                <td>
                                    {{date('m j, y',strtotime($chapter->updated_at))}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                {{$chapters->links()}}
            </div>
        </div>
        @endsection