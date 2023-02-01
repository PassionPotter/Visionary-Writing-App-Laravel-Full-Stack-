<!DOCTYPE html>

    @yield('styles')
        <!-- Fonts -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width">
    <style>
.note-popover.popover{max-width:none;display: none;}
    .sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
    <!-- Scripts -->
     <script src="{{asset('js/app.js')}}"></script>
     <script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
        <div class="container">

            <div class="row">
                <div class="col-lg-1">
                    @if(Auth::check())
                     <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
                    <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="{{route('home')}}">home</a>
                    <a href="{{route('book/create')}}">New book</a>
                    <a href="{{route('chapter/create')}}">New chapter</a>
                    <a href="{{route('draft/books')}}">View draft</a>
                    <a href="{{route('books')}}">books</a>
                    <a href="{{route('trashed.books')}}">Trashed books</a>
                    @if(Auth::user()->admin)
                    <a href="{{route('users')}}">Users</a>
                    <a href="{{route('user.create')}}">New users</a>
                    @endif
                    <a href="{{route('user.profile')}}">edit profile</a>
                    </div>
                    @endif
                </div>

                <div class="col-lg-11">
                    @yield('content')
                </div>
            </div>
        </div>
            
          
            <link rel="stylesheet" href="{{ asset('css/croppie/croppie.css') }}">
             <link rel="stylesheet" href="{{ asset('css/croppie/style.css') }}">
           <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
           
<div class="modal fade" id="imguplod" role="dialog">
    <div class="modal-dialog modal_big" style=" transform: translate(0,-2%);">
        <div class="modal-content">
           
             
              
           
            <div class="modal-body frm_box">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="row" style=" display: block; ">
                <h3>Upload & Crop Image</h3> 
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="row" style=" display: block; ">
                        <div class="col-md-12 text-center">
                            <div id="upload-image"></div>
                        </div>
                        <div class="col-md-12">
                            <strong>Select Image:</strong>
                            <br/>
                            <input type="file" id="images">
                            <br/>
                            <button class="btn btn-success cropped_image">Upload Image</button>
                        </div>          
                       <!--  <div class="col-md-12 crop_preview">
                            <div id="upload-image-i"></div>
                        </div> -->
                    </div>
                  </div>
                </div>          
            </div>
            </div>
           
        </div>
    </div>
</div>

<script src="{{ asset('css/croppie/croppie.js') }}"></script>
<script type="text/javascript" src="{{ asset('css/croppie/upload.js') }}"></script>
<script>
    @if(Session::has('success'))
        toastr.success("{{Session::get('success')}}");
    @endif

 @if(Session::has('info'))
        toastr.info("{{Session ::get('info')}}");
    @endif

 @if(Session::has('failure'))
    toastr.error("{{Session::get('failure')}}");
  @endif
</script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script type="text/javascript">
//var jq = $.noConflict();
    $(document).ready(function() {
         $('#profile-description').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            height: 300
        });
        $("#uId").click(function(){
            $('#imguplod').modal('show');
        });

         $("#fileuId").change(function() {
            $("#message").empty(); 
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                $('#uId').attr('src',"../books/avatars/avatar.png");

                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);

            }
        });

        function imageIsLoaded(e) {
            $("#file").css("color","green");

            $('#thankYou').modal('show');

            jquploadCrop = $('#cropper-1').croppie({
                enableExif: true,
                url: e.target.result,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 250,
                    height: 250
                }
            });

            Demo.init();

        };
    });

    $(function(){    
    var jq = $.noConflict();
    $image_crop = jq('#upload-image').croppie({
        enableExif: true,
        viewport: {
            width: 250,
            height: 250,
            type: 'circle'
        },
        boundary: {
            width: 400,
            height: 400
        }
    });
    $('#images').on('change', function () { 
        var reader = new FileReader();
        reader.onload = function (e) {
            $image_crop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });         
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('.cropped_image').on('click', function (ev) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            var pathname = window.location.pathname;
            //alert($(location).attr('host'));'input[name="FirstName"]'
            var token = $("input[name='__token']").val();
            $.ajax({
                url: $(location).attr('protocol') + "//" + $(location).attr('host') + "/customer/ajaxupdateuser",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {"_token":$('meta[name="csrf-token"]').attr('content'),"image":response},
                success: function (data) {
                   $('#uId').attr('src', 'https://visionarywritings.com/books/avatars/' + data.avatar);
                    $('#avatar').val(data.avatar);
                    $('#imguplod').modal('hide');
                }
            });
        });
    }); 
});
</script>
@yield('scripts')
</body>
</html>
