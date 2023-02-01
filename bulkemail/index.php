<?php
session_start();
include('config.php');

if($_SESSION['ulog']){
header("location:send_mail.php");
exit;
}

if(isset($_POST['sign_in']))
{

   if($_POST['username'] == $username && $_POST['password']== $password){
   
         $_SESSION['ulog'] ='yes';
		 header("location:send_mail.php");
		 exit;
   
   }
   else{
    
        header("location:index.php?msg=error");
		exit;
   
   }



}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Visionary Writings</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style>

.hlogo {
  
    float: left;
	width: 100%;
	text-align: center;
	padding-bottom:30px;
}
.hlogo img { width:20%;  }
.btn {  text-align:center;}

.panel-info > .panel-heading{
   
   background:none;
   border:none;

}
.btn-success {color:#333; background:#eee; border:#eee;  }
.btn-success:hover { background:#eee; color:#333; }

</style>

<body>



 <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                      
						  <div class="hlogo"><img src="images/logo.jpg">
						
						
						 	   <?php  if($_GET['msg']=='error') { ?> 
						  
							  <div class="alert alert-danger">
							 
								   <?php echo "Invalid login details"; ?>
								   
						        </div>  <?php } ?>
						 </div>	 
							
					 </div>
			
					      

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                                    </div>
                                 


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 btn">
                                        <button type="submit" class="btn btn-default" name="sign_in">Login</button>
                                    
                                    </div>
                                </div>
                         </form>     
                        </div>                     
                    </div>  
         </div>

 </div>
</body>
</html>
