@extends('frontend.layouts.master')
@section('content')
<div class="container">
        <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
        <div class="panel-heading">Registration</div>
        <div class="panel-body">
          Your profile was successfully created, please check your email to verify your account
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

        <p><a href="{{URL::to('login/')}}"  class="btn btn-info"> click to Login</a></p>
       
        </div>
        </div>
        </div>
        </div>
        </div>
        @endsection