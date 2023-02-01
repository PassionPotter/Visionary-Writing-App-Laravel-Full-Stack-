<?php
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

    @media (min-width: 768px) {
        .col-sm-6 {
            width: 100%;
        }
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
                                <h3 style="display: inline-block;">Bank Details</h3>
                                @if(count($bank_details) < 1) <a href="{{ URL::to('/admin/bank/add') }}" class="btn btn-info" style="display: inline-block;margin-bottom: 10px; float: right;;">Add Bank Details</a>
                                    @endif
                                    <div class="clearfix"></div>
                            </div>
                            @if($mobileDetect)
                            @if(Auth::check())
                            @if(count($bank_details) > 0)
                            @foreach($bank_details as $bData)
                            <div class="row comment-row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="clearfix">
                                        <h5 class="comment-user">Account Name: {{$bData->name}} {{ $bData->surname }}</h5>
                                        <h5 class="comment-user">Bank: {{$bData->bank_name}}</h5>
                                        <h5 class="comment-user">Account no: {{ $bData->account_number }}</h5>
                                        <h5 class="comment-user">Branch: {{$bData->branch}}</h5>
                                    </div>
                                    <div class="comment-actions">
                                        <a href="{{ URL::to('admin/bank/edit', $bData->id) }}" class="btn btn-xs btn-warning">Edit</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="alert alert-dark" role="alert">
                                No bank details added.
                            </div>
                            @endif
                            @endif
                            @else
                            <div class="x_content">
                                <div class="table-responsive" data-pattern="priority-columns">
                                    <table class="table table-small-font table-hover table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>Bank Name</th>
                                                <th>Account Number</th>
                                                <th>Bank Branch</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(Auth::check())
                                            @if(count($bank_details) > 0)
                                            <?php $x = 1 ?>
                                            @foreach($bank_details as $bData)
                                            <tr>
                                                <td>{{ $x }}</td>
                                                <td>{{ $bData->name }}</td>
                                                <td>{{ $bData->surname }}</td>
                                                <td>{{ $bData->bank_name }}</td>
                                                <td>{{ $bData->account_number }}</td>
                                                <td>{{ $bData->branch }}</td>
                                                <td><a href="{{ URL::to('admin/bank/edit', $bData->id) }}" class="btn btn-warning">Edit</a></td>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection