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

</style>

  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-body">

<div class="row">

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
                </tr>
                </thead>
                <tbody>
                @if(Auth::check())
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
            <?php
            echo $transaction_data->links();
            ?>

            

           
        </div>
    </div>
    @endsection
    @section('scripts')
