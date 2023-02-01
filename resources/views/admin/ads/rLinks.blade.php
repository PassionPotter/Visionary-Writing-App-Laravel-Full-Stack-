@extends('admin.layouts.master')
@section('content')
   <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{url('/admin/ad/restrict')}}" class="btn btn-success" style="margin-bottom:15px;">Add New</a>
            <h3>Restricted Links</h3>
            <div class="table-responsive">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rlinks as $rlink)
                        <tr>
                            <td>{{$rlink->id}}</td>
                            <td><a href="{{$rlink->link}}">Visit Link</a></td>
                            <td>
                                @if($rlink->status == 1)
                                    Activated
                                @else
                                    Deactivated
                                @endif
                            </td>
                            <td>
                                @if($rlink->status == 1)
                                    <a href="{{url('admin/ad/strict/links/deactivate')}}/{{$rlink->id}}" class="btn btn-danger">Deactivate</a>
                                @else
                                    <a href="{{url('admin/ad/strict/links/activate')}}/{{$rlink->id}}" class="btn btn-success">Activate</a>
                                @endif
                                <a href="{{url('admin/ad/strict/links/delete')}}/{{$rlink->id}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
@endsection
 