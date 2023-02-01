@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <form action="{{ URL::to('/admin/bank/update') }}" method="post" enctype="multipart/form-data">
        {!!  csrf_field() !!}

        <input type="hidden" name="bank_id" id="bank_id" value="{{ $bankData[0]->id }}">

  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter Name" value="{{ $bankData[0]->name }}">
  </div>

  <div class="form-group">
    <label for="surname">Surname</label>
    <input type="text" name="surname" class="form-control" id="surname" aria-describedby="surname" placeholder="Enter Surname" value="{{ $bankData[0]->surname }}">
  </div>

    <div class="form-group">
    <label for="bank_name">Bank Name</label>
    <input type="text" name="bank_name" class="form-control" id="bank_name" aria-describedby="bank_name" placeholder="Enter Bank Name" value="{{ $bankData[0]->bank_name }}">
  </div>

  <div class="form-group">
    <label for="account_number">Account Number</label>
    <input type="text" name="account_number" class="form-control" id="account_number" aria-describedby="account_number" placeholder="Enter Account Number" value="{{ $bankData[0]->account_number }}">
  </div>

  <div class="form-group">
    <label for="branch">Branch</label>
    <input type="text" name="branch" class="form-control" id="branch" aria-describedby="branch" placeholder="Enter Branch" value="{{ $bankData[0]->branch }}">
  </div>

  <div class="form-group">
  <button type="submit" class="btn btn-primary">Update Details</button>
   </div>
</form>
@endsection

