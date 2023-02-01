<?php

use Illuminate\Support\Str;

function isMobileDevice()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$mobileDetect = isMobileDevice();
?>
@extends('admin.layouts.master')
@section('content')
<style type="text/css">
    .panel-green {
        border-color: green;
    }

    .panel-green .panel-heading {
        color: #fff;
        background-color: green;
        border-color: green;
    }

    .panel-brown {
        border-color: brown;
    }

    .panel-brown .panel-heading {
        color: #fff;
        background-color: brown;
        border-color: brown;
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
                                <h3>Payment Details</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if($mobileDetect)
                                    @if(Auth::check())
                                        @if(count($payment_details) > 0)
                                        <?php $x = 1 ?>
                                            <div class="responsive-view-list">
                                            @foreach($payment_details as $pData)
                                                <?php
                                                    if (Auth::user()->id != $pData->admin_id) {
                                                        foreach ($user_details as $key => $value) {
                                                            if ($pData->admin_id == $value->id) {
                                                                $name = $value->name;
                                                            }
                                                        }
                                                        $type = 'credit';
                                                    } else {
                                                        foreach ($user_details as $key => $value) {
                                                            if ($pData->user_id == $value->id) {
                                                                $name = $value->name;
                                                            }
                                                        }
                                                        $type = 'debit';
                                                    }
                                                ?>
                                                
                                                <div class="row comment-row">
                                                    <div class="col-md-3 col-xs-12">
                                                        <h5 class="book-title">{{ $name }} <span class="label pull-right label-{{$type == 'credit' ? 'success' : 'danger'}}">{{$type}}</span></h5>
                                                        <div class="book-price">R{{ number_format($pData->amount, 2) }}
                                                        <p class="book-author pull-right">{{ $pData->created_at }}</p>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table class="table table-small-font table-hover table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(Auth::check())
                                                @if(count($payment_details) > 0)
                                                <?php $x = 1 ?>
                                                @foreach($payment_details as $pData)

                                                <?php
                                                if (Auth::user()->id != $pData->admin_id) {
                                                    foreach ($user_details as $key => $value) {
                                                        if ($pData->admin_id == $value->id) {
                                                            $name = $value->name;
                                                        }
                                                    }
                                                    $type = 'credit';
                                                } else {
                                                    foreach ($user_details as $key => $value) {
                                                        if ($pData->user_id == $value->id) {
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
                                @endif
                            </div>
                        </div>
                    </div>





                </div>

                {{$payment_details->links()}}


            </div>
        </div>
        @endsection
        @section('scripts')