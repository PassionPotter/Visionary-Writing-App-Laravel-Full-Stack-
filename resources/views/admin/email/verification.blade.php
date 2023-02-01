@extends('frontend.layouts.master')
@section('content')
<div class="container">
        <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
        <div class="panel-heading">Registration</div>
        <div class="panel-body">
        You have successfully registered. An email is sent to you for verification.
         <?php
        // print_r($user);
         if(!empty($email)){
             $email = $email;
             ?>
            
             <?php
         }else{
             $email = $user['email'];
         }
        
        
        ?>

        <p><a href="{{URL::to('emailresend/'.$email)}}"  class="btn btn-info"> click to Resend Email</a></p>
        <?php if (isset($status)): ?>
                <div class="alert alert-danger" role="alert">{{$status}}</div>
        <?php endif ?>
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
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$email}}" required autofocus>

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