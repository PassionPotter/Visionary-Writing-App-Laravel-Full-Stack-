@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-hover table-responsive">
                <thead>
                    <th>
                        Id
                    </th>
                    <th>
                        Section
                    </th>
                    <th>
                            page
                        </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Operation
                    </th>
                </thead>
                <tbody>
                @if(Auth::user()->admin)
                @foreach($ads as $ad)
                        <tr>   
                        <td>
                        {!! $ad->id !!}
                            </td>

                            <td>
                         {!! $ad->type !!}
                            </td>

                            <td>
                         {!! $ad->page !!}
                            </td>

                              <td>
                        @if($ad->status)
                         <p>Active</p>
                         @else
                         <p>Inactive</p>
                         @endif
                            </td>
                        <td>
                            @if($ad->status)
                            <a href="{{route('deactivate',['id' => $ad->id])}}" class="btn btn-primary">Deactivate</a>    
                        @else
                        <a href="{{route('activate',['id' => $ad->id])}}" class="btn btn-success">activate</a>
                    
                        @endif
                        </td>
                            <td>
                        <a href="{{route('edit',['id' => $ad->id])}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                         <a href="{{route('delete',['id' => $ad->id])}}" class="btn btn-danger">Delete</a>
                            </td> 
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        </div>
    </div>
    @endsection
 