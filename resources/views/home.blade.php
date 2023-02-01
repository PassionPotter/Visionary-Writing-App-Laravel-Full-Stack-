@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>

            <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
            <input type="file" name="bbok">
            <button class="btn btn-primary">submit</button>
            </form>
@endsection
