@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <form action="{{ URL::to('/admin/bank/add') }}" method="post" enctype="multipart/form-data">
        {!!  csrf_field() !!}

  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter Name" value="{{ old('name') }}">
  </div>

  <div class="form-group">
    <label for="surname">Surname</label>
    <input type="text" name="surname" class="form-control" id="surname" aria-describedby="surname" placeholder="Enter Surname" value="{{ old('surname') }}">
  </div>

    <div class="form-group">
    <label for="bank_name">Bank Name</label>
    <input type="text" name="bank_name" class="form-control" id="bank_name" aria-describedby="bank_name" placeholder="Enter Bank Name" value="{{ old('bank_name') }}">
  </div>
  
  <div class="form-group">
    <label for="account_number">Account Number</label>
    <input type="text" name="account_number" class="form-control" id="account_number" aria-describedby="account_number" placeholder="Enter Account Number" value="{{ old('account_number') }}">
  </div>

  <div class="form-group">
    <label for="branch">Branch</label>
    <input type="text" name="branch" class="form-control" id="branch" aria-describedby="branch" placeholder="Enter Branch" value="{{ old('branch') }}">
  </div>

  <div class="form-group">
  <button type="submit" class="btn btn-primary">Add Details</button>
   </div>
</form>
@endsection

