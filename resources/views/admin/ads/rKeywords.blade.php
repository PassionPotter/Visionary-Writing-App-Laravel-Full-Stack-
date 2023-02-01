@extends('admin.layouts.master')
@section('content')
   <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{url('/admin/ad/restrict')}}" class="btn btn-success" style="margin-bottom:15px;">Add New</a>
            <h3>Restricted Keywords</h3>
            <div class="table-responsive">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Keyword</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rkeywords as $rkeyword)
                        <tr>
                            <td>{{$rkeyword->id}}</td>
                            <td>{{$rkeyword->keyword}}</td>
                            <td>
                                @if($rkeyword->status == 1)
                                    Activated
                                @else
                                    Deactivated
                                @endif
                            </td>
                            <td>
                                @if($rkeyword->status == 1)
                                    <a href="{{url('admin/ad/strict/keywords/deactivate')}}/{{$rkeyword->id}}" class="btn btn-danger">Deactivate</a>
                                @else
                                    
                                    <a href="{{url('admin/ad/strict/keywords/activate')}}/{{$rkeyword->id}}" class="btn btn-success">Activate</a>
                                @endif
                                <a href="{{url('admin/ad/strict/keywords/delete')}}/{{$rkeyword->id}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
@endsection
 