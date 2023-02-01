@extends('frontend.layouts.master')
@section('style')
<style>
.contact-form{ margin-top:15px;}
.contact-form .textarea{ min-height:220px; resize:none;}
.form-control{ box-shadow:none; border-color:#eee; height:49px;}
.form-control:focus{ box-shadow:none; border-color:#00b09c;}
.form-control-feedback{ line-height:50px;}
.main-btn{ background:#00b09c; border-color:#00b09c; color:#fff;}
.main-btn:hover{ background:#00a491;color:#fff;}
.form-control-feedback {
line-height: 50px;
top: 0px;
}
</style>
@endsection
@section('content')



<div class="about">
        <div class="container">
                <h2>Contact us</h2>		
                <br>
                <h3>For any questions, problems or if you would like to know more about us, feel free to contact us and we will reply.
                </h3>
                <hr>
                @include('email.errors')
                @if (!empty($success))
                <div class="alert alert-success alert-block">
                    {{ $success }}
                </div>
                @endif
        <div class="biography">

                <div class="biographys">
                        <div class="col-md-12 biography-into">
                            <h3>Existing authors and Authors that want to join us, please click <b>“Become an author”</b> on the top navigation tab  for more info.</h3>
                        </div>
                        <div class="clearfix"> </div>
                </div>

                <div class="biographys">
                    <div class="col-md-12 biography-into">
                        <hr>
                        <p>SUGGESTIONS, COMPLIMENTS OR COMPLAINTS. FILL THE FORM BELOW</p>
                        <hr>
                            <form role="form" method="post" action="{{route('submit-contact-form')}}">
                                {{csrf_field()}}
                                    <div class="form-group col-lg-6">
                                        <label class="form-control-label" for="form-group-input">Name</label>
                                        <input type="text" class="form-control" id="form-group-input" name="name" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="form-control-label" for="form-group-input">Email</label>
                                        <input type="text" class="form-control" id="form-group-input" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="form-control-label" for="form-group-input">Message</label>
                                        <textarea class="form-control" id="form-group-input" name="Message" rows="6">{{ old('Message') }}</textarea>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <input type="hidden" name="secret" value="6LegRWoUAAAAAFyIUdCij1qkVAAkL4zy4-CD7YM6">
                                        <input type="hidden" name="response" value="g-recaptcha-response">
                                        <input type="hidden" name="remoteip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                                    <div class="g-recaptcha" data-sitekey="6LegRWoUAAAAAP6Lc2bZf3dyg-kgQZaX8W8Se0Id"></div>
                                </div>
                                            <div class="col-md-12">
                                          <button type="submit" class="btn main-btn pull-right">Send a message</button>
                                          </div>
                                </form>
                    </div>
                <div class="clearfix"> </div>
            </div>
        </div>
            </div>
            </div>

            <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection