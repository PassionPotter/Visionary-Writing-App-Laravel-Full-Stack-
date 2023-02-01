@extends('admin.layouts.master')
@section('content')
<style type="text/css">

.panel-green{
    border-color:green;
}  
.panel-green .panel-heading{
    color: #fff;
    background-color:green;
    border-color:green;
}  

.panel-brown{
    border-color:brown;
}  
.panel-brown .panel-heading{
    color: #fff;
    background-color:brown;
    border-color:brown;
}  

.panel-grey{
    border-color:#009999;
}  
.panel-grey .panel-heading{
    color: #fff;
    background-color:#009999;
    border-color:#009999;
}  

</style>

  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">

<div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-star fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    
                                    <div>Profile Views!</div>
                                    <div class="huge">{{$authors_view_count}}</div>
                                </div>
                            </div>
                        </div>
<!--                         <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Book Views!</div>
                                    <div class="huge">{{$total_book_views}}</div>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-brown">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-money fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Wallet Balance</div>
                                    <div class="huge">R{{ number_format($user_data[0]->amount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>

                @if(!Auth::user()->admin)
                @if($user_data[0]->amount >= 250)

                <a href="{{ URL::to('admin/requestPayment', $user_data[0]->id) }}">
                <div class="col-lg-3 col-md-6">
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
                </a>

                @endif
                @endif


                <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Monthly Earnings</h3>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                <div class="table-responsive" data-pattern="priority-columns">
                <table class="table table-small-font table-hover table table-striped table-bordered">
                <thead>
                <tr>
                <th>#</th>
                <th>Month</th>
                <th>Amount</th>
                @if(count($transaction_data) > 0)
                <th><a href="{{route('/monthlyearning')}}" class="btn btn-primary">View All</a></th>@endif
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
                </div>

                

                <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Payment Details</h3>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                <div class="table-responsive" data-pattern="priority-columns">
                <table class="table table-small-font table-hover table table-striped table-bordered">
                <thead>
                <tr>
                <th>#</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Date</th>
                @if(count($payment_details) > 0)
                <th><a href="{{route('/payment/details')}}" class="btn btn-primary">View All</a></th>@endif
                </tr>
                </thead>
                <tbody>
                @if(Auth::check())
                @if(count($payment_details) > 0)
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
                        @else
                        <tr>
                        <td colspan="10" style="text-align: center;">No Data Available!</td>
                        </tr>
                        @endif                       
                   
                @endif
                        </tbody>
                    </table>
                </div>
                </div>
                </div>
                </div>



            </div>

           
        </div>
    </div>
    @endsection
    @section('scripts')
