@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
    @include('admin.errors.errors')

    @if(session()->has('error_msg'))
    <div class="alert alert-danger alert-block">
      <ul>
      <li>{{ session()->get('error_msg') }}</li>
      </ul>
    </div>
    @endif

    @if(session()->has('success_msg'))
    <div class="alert alert-success alert-block">
      <ul>
      <li>{{ session()->get('success_msg') }}</li>
      </ul>
    </div>
    @endif

    <div class="graphs">
<!--       <div class="panel-heading">
            Payment
        </div> -->
    <form action="{{ route('payment/send') }}" method="post" enctype="multipart/form-data">
        {!!  csrf_field() !!}
  <div class="form-group">
    <label for="user">User</label>
  @if(Auth::user()->admin)
        <select name="user" id="user" class="form-control">
          <option value="">-Select User-</option>
            @foreach($all_user as $allusers)
            ` @if($allusers->active)
                  <option value="{{$allusers->id}}">{{$allusers->name}}</option>
                 @endif
             @endforeach
     </select>  
     @endif
  </div>

     <div class="form-group">
    <label for="amount">Amount</label>
    <input type="number" id="amount" name="amount" min="1" class="form-control" value="{{ old('amount') }}">
  </div> 
  <div class="form-group">
  <input type="hidden" id="admin_amt" name="admin_amt" value="{{ $admin_details[0]->amount }}">
  <button type="submit" class="btn btn-primary">Send</button>
   </div>
</form>
</div>
</div>
@endsection
