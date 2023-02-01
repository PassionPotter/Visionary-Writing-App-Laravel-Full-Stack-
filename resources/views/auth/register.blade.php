@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Become an author</div>

                <div class="card-body">
                    <div style="text-align: center;">
                <img style="width: 80px;" height="80px;" src="{{asset('public/user-avatar.png')}}" id="uId" style="cursor: pointer;margin: 0 auto;" title="click for image chang" class="img-responsive" /></div>
                <br>
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                         <input type="hidden" name="avatar" id="avatar" class="form-control" value="avatar.png">
                         <input type="hidden" name="reader" class="form-control" value="0">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <input id="male" type="radio" class="" name="gender" value="Male" required checked="checked"> Male
                                </div>
                                <div class="col-md-6">
                                <input id="Female" type="radio" class="" name="gender" value="Female" required>Female
                                </div>
                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('DOB') }}</label>

                            <div class="col-md-6">
                                <input id="dob" type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ old('dob') }}" required >

                                @if ($errors->has('gander'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('gander') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <!--  --><div class="form-group row">
                            <label class=" col-form-label text-md-left">
                        
                    </label>
                </div>
                <p style="background-color: #ff7529;margin-left: 23%;">Always Add country code +27 before your phone number.</p>
                        <!-- phone -->
                           <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }} </label>
                            

                            <div class="col-md-6">

                                <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="+27"  placeholder="Number should starts with +27" required>
                                

                                @if ($errors->has('gander'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('gander') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="about" class="col-md-4 col-form-label text-md-right">{{ __('About') }}</label>
                             <div class="col-md-8">
                            <textarea name="about" id="profile-description" cols="110" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
