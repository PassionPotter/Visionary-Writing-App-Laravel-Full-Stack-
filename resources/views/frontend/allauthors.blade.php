<?php

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
?>
@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <!-- removed class mobileview -->
    <h3 class="margin-bottom-20"><span>All Authors</span></h3>
    <?php $counter = 0; ?>
    <div class="row mobileviewclass">
        @foreach($users as $user)

        <?php
        if($counter == 10){
            continue;
        } 
        if ($user->admin == 1) {
            continue;
        }

        ?>
        <div class="book_col clearfix">
          <div class="book_image">
              <div>
                 <?php if(isset($user->profile->avatar)){?>
                <a href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->user_id])}}">
                    <img data-src="{{asset('public/books/avatars/T-'.$user->profile->avatar)}}" alt="{{$user->name}}" class="img-responsive center-block lazyload" />
                </a>
             <?php } ?>
              </div>
          </div>
          <div class="book_details">
              <h3>{{$user->name}}</h3>
              <p></p>
              <a class="buttons read_btt" href="{{route('author/author_id',['id' => $user->id])}}"> View Profile</a>
          </div>
      </div>
<?php $counter++; ?>
@endforeach





</div>
</div><!-- /.container -->


@endsection