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
       
        </div>
        </div>
        </div>
        </div>
        </div>
        @endsection