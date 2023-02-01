@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Phone Verification area </div>
                <div class="card-body">
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('verify-phone') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="number_code" class="col-sm-4 col-form-label text-md-right">Code <small>Enter your 5 digit code here</small></label>

                            <div class="col-md-6">
                                <input id="number_code" type="number" class="form-control{{ $errors->has('number_code') ? ' is-invalid' : '' }}" name="number_code" value="{{ old('number_code') }}" required autofocus>

                                @if ($errors->has('number_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('number_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
