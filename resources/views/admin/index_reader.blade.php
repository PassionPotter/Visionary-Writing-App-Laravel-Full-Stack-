<?php
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$mobileDetect = isMobileDevice();
?>
@extends('admin.layouts.master')
@section('content')
<div id="page-wrapper">
    @if($mobileDetect)
    @include('admin.errors.errors')
    <!-- Author name and Profile -->
    <div class="container">
        <div class="row profile-dash-top">
            <div class="col-md-6 col-xs-4">
                <div class="profile-img-container">
                @if(Auth::check())
                    <img src="{{asset('public/books/avatars')}}/{{Auth::user()->avatar}}" class="profile-image" alt="Responsive Image">
                       <!-- <a  href = "{{route('user.profile')}}"><i class="fa fa-pencil-square-o edit" aria-hidden="true"></i></a> -->
                @endif
                </div>
            </div>
            @if(Auth::check())
            <div class="col-md-6 col-xs-8">
                <div class="author">
                    <div class="huge text-justify"><b>NAME:</b> <span class="ellipsis">{{Auth::user()->name}}</span></div>
                </div>
                <div class="author">
                    <div class="huge text-justify"><b>DOB:</b> {{Auth::user()->profile->dob}}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Add book Operation -->
    <!-- <div class="row m-t-10">
        <div class="col-xs-12">
            <div class="col-xs-offset-3 col-xs-3">
                <a href="{{route('book/create')}}" class="btn btn-info btn-block new-option">Add Books</a>
            </div>
            <div class="col-xs-3">
                <a href="{{route('chapter/create')}}" class="btn btn-info btn-block new-option">Add Chapter </a>
            </div>
        </div>
    </div> -->
    <!-- # option -->
    
    @if(!Auth::user()->admin)
    @if($user_data[0]->amount >= 250)
    <!-- <a href="{{ URL::to('admin/requestPayment', $user_data[0]->id) }}">
        <div class="col-lg-3 col-md-6 mob-req-payment">
            <div class="panel panel-grey">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-arrow-circle-right fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div>Request Payment</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a> -->
    @endif
    @endif
    <!-- <div class="col-md-12 col-sm-6 col-xs-12 hidden-xs">
        <div class="x_panel">
            <div class="x_title">
                <h3>Monthly Earnings</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-small-font table-hover table table-striped table-bordered m-t-10">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Month</th>
                                <th>Amount</th>
                                @if(count($transaction_data) > 0)
                                <th><a href="{{route('/monthlyearning')}}" class="btn btn-primary">View
                                        All</a></th>@endif
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($transaction_data) > 0)
                            <?php $x = 1 ?>
                            @foreach($transaction_data as $tData)

                            <tr>
                                <td>{{ $x }}</td>
                                <td><?php
                                $date = $tData->monthyear.'-01';
                                echo date("M-Y", strtotime($date));
                                ?></td>
                                <td>R{{ number_format($tData->amount, 2) }}</td>
                                <td></td>

                            </tr>
                            <?php $x++ ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" style="text-align: center;">No Data Available!</td>
                            </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="col-md-12 col-sm-6 col-xs-12 hidden-xs">
        <div class="x_panel">
            <div class="x_title">
                <h3>Payment Details</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table class="table table-small-font table-hover table table-striped table-bordered m-t-10">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                        @if(Auth::check())
                        @if(count($payment_details) > 0 && count($user_details) > 0)
                        <?php $x = 1 ?>
                        @foreach($payment_details as $pData)
                        <?php
                                            if(Auth::user()->id != $pData->admin_id){
                                            
                                            foreach ($user_details as $key => $value) {
                                                if($pData->admin_id == $value->id){
                                                    $name = $value->name;
                                                }
                                            }
                                            $type = 'credit';
                                            }else{
                                            foreach ($user_details as $key => $value) {
                                                if($pData->user_id == $value->id){
                                                    $name = $value->name;
                                                }
                                            }
                                            $type = 'debit';
                                            }
                                        ?>
                        <tr>
                            <td>{{ $x }}</td>
                            <td>{{ $name }}</td>
                            <td>R{{ number_format($pData->amount, 2) }}</td>
                            <td>{{ $type }}</td>
                            <td>{{ $pData->created_at }}</td>
                        </tr>
                        <?php $x++ ?>
                        @endforeach
                        @endif
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div> -->
</div>

<!-- WEB VIEW -->
@else
@include('admin.errors.errors')
<div class="graphs">
    <div class="panel panel-default">
       
    </div>
</div>
@endif
</div>
@endsection
@section('scripts')