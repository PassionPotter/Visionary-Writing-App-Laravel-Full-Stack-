@extends('admin.layouts.master')
@section('content')
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-heading">
            Create a new user
        </div>
        <div class="panel-body">
            <img src="{{asset('books/avatars/avatar.png')}}" id="uId" style="cursor: pointer;" title="click for image chang" class="img-responsive" />
            <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                 <input type="hidden" name="avatar" id="avatar" class="form-control" value="avatar.png">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                 <div class="form-group">
                    <label for="name">email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="name">Gender</label>
                   <div >
                                    <input id="male" type="radio" class="" name="gender" value="Male" required checked="checked"> Male
                                </div>
                                <div >
                                <input id="Female" type="radio" class="" name="gender" value="Female" required>Female
                                </div>
                </div>
                <div class="form-group">
                    <label for="name">DOB</label>
                     <input id="dob" type="date" class="form-control" name="dob"  required>
                </div>
                 <div class="form-group">
                 <!-- <label for="name">Avatar</label>
                 <input type="file" name="import-users" id="usersFile"> -->
                 </div>
                <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                <button class="btn btn-success" type="submit">Add user</button>
                    </div>
                     <div class="col-md-3">
                
                     </div>
                      <div class="col-md-2">
                 <a href="#" class="btn btn-primary" type="submit" id="ImportUsers">Import users</a>
                </div>
                </div>
                </div>
                </form>
        </div>
    </div>
    <div class="modal fade" id="imguplod" role="dialog">
    <div class="modal-dialog modal_big">
        <div class="modal-content">
           
             
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                <script src="{{ asset('css/croppie/croppie.js') }}"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                <link rel="stylesheet" href="{{ asset('css/croppie/croppie.css') }}">
                <script type="text/javascript" src="{{ asset('css/croppie/upload.js') }}"></script>
                <link rel="stylesheet" href="{{ asset('css/croppie/style.css') }}">
           
            <div class="modal-body frm_box">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="row">
                <h3>Upload & Crop Image</h3> 
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="row">
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
@endsection

@section('scripts')
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
   $(document).ready(function() {
      document.getElementById("ImportUsers").addEventListener('click',importUsers);
        function importUsers(e){
        var usersFile = $('#usersFile').prop('files')[0];
          var formData = new FormData();
          formData.append('usersFile',usersFile);
            $.ajax({
              url:"{{route('users/import')}}",
              type:"post",
              data:formData,
             processData: false,
            contentType: false,
          success: function(response){
            toastr.success("Users imported successuly");
          },
          error:function(err){
              console.log(err);
               toastr.error("Errors while importing users! did you import a file?");
          }
      });
       }
    });

</script>

<script type="text/javascript">
var jq = $.noConflict();
    jq(document).ready(function() {
        jq('#profile-description').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            height: 300
        });
        jq("#uId").click(function(){
            jq('#imguplod').modal('show');
        });

         jq("#fileuId").change(function() {
            jq("#message").empty(); 
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                jq('#uId').attr('src',"../books/avatars/avatar.png");

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
            jq("#file").css("color","green");

            jq('#thankYou').modal('show');

            jquploadCrop = jq('#cropper-1').croppie({
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

    jq(function(){    
    
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
    jq('#images').on('change', function () { 
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
    jq('.cropped_image').on('click', function (ev) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            var pathname = window.location.pathname;
            //alert($(location).attr('host'));'input[name="FirstName"]'
            var token = jq("input[name='__token']").val();
            $.ajax({
                url: jq(location).attr('protocol') + "//" + jq(location).attr('host') + "/customer/ajaxupdateuser",
                type: "POST",
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                data: {"_token":jq('meta[name="csrf-token"]').attr('content'),"image":response},
                success: function (data) {
                   jq('#uId').attr('src', 'https://visionarywritings.com/books/avatars/' + data.avatar);
                    jq('#avatar').val(data.avatar);
                    jq('#imguplod').modal('hide');
                }
            });
        });
    }); 
});
</script>
@endsection