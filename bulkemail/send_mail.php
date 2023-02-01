<?php


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);
session_start();

$msg = '';

include('config.php');



if(!$_SESSION['ulog']){



	header("location:index.php");



	exit;



}



?>



<!DOCTYPE html>



<html lang="en">



<head>



	<title>Send email</title>



	<meta charset="utf-8">



	<meta name="viewport" content="width=device-width, initial-scale=1">



	<link href="css/bootstrap.css">



	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">



	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



	<script src="ckeditor.js"></script>



	<style>



		.ck-editor__editable {



			min-height: 230px;



		}



		.panel-info { border:none;}  



		label{ color:#333;  }



		h2 { text-align:center; color:#fff; padding-bottom:10px; }



		.btn.btn-default { }



		.main { background:#333; padding-bottom: 10px;}



		.maintitle h1{ color:#fff; font-size: 26px; margin-top: 26px; }



		.logo { float:right; margin-top: 13px;}



		.logo img { max-width:40%; }



		.middlepart { background:#eee; padding-bottom:13px; }



		.sidenav a i { padding-right: 6px; }



		.sidenav a.active i { color:#fff;  }



		.panel { margin-bottom:0px; margin-top:20px; }



		.panel-heading p { font-size:15px; } 



		.sidenav {



			height: 100%;



			width: 200px;



			position: fixed;



			z-index: 1;



			left: 0;



			background-color: #111;



			overflow-x: hidden;



			padding-top: 20px;



		}







		.sidenav a {



			padding: 6px 8px 6px 16px;



			text-decoration: none;



			font-size: 14px;



			color: #818181;



			display: block;



		}



	</style>



</head>







<?php











?>



<body>







	<div class="container-fluid main">







		<div class="col-md-6 col-sm-6 maintitle">







			<h1>Visionary Writings</h1>



		</div>



		<div class="col-md-6 col-sm-6 mainloggo">







			<div class="logo">







				<img src="images/logo.jpg">







			</div>







		</div>



	</div>







	<div class="container-fluid middlepart">



		<div class="col-md-2 col-sm-2 maintitle">







			<div class="sidenav">







				<a href="https://visionarywritings.com/bulkemail/send_mail.php" class="active"><i class="fa fa-envelope"></i>Send Email to All Users</a>



				<a href="https://visionarywritings.com/bulkemail/logout.php"><i class="fa fa-sign-out"></i>Logout</a>



			</div>







		</div>







		<div class="col-md-10 col-sm-10 mform">

			<div class="panel panel-default">



				<div class="panel-heading"><p>Send Email to All Users</p></div>



			</div>	





			<div class="form" style="background-color:#fff;width:100%; padding:33px;">



				<?php

				use PHPMailer\PHPMailer\PHPMailer;

				use PHPMailer\PHPMailer\Exception;



				if(isset($_POST['email_send'])){

					if(($_POST['author_mail'] || $_POST['reader_mail']) && ($_POST['message']!='') && ($_POST['subject']!='')){

					require 'phpmailer/vendor/autoload.php';

					$mail = new PHPMailer(true);

					try {



						$mail->SMTPDebug = false;

    					//$mail->isSMTP();

						$mail->Host = 'mail.visionarywritings.com';



					    // $mail->Username = 'authors@visionarywritings.com';

					    // $mail->Password = 'shgJo6X&FNL~Zu[lHm';

					    // $mail->SMTPSecure = 'ssl';

					    // $mail->Port = 465;  
						$mail->Username = 'admin@visionarywritings.com';

						$mail->Password = 'hjp3d96nautj6bzc';

						$mail->SMTPSecure = 'ssl';

						$mail->Port = 587; 


						$mail->SMTPAuth = true;

						$mail->SMTPSecure = true;

						$mail->setFrom('authors@visionarywritings.com', 'visionarywritings');



						$mes=$_POST['message'];

						$sub=$_POST['subject'];	

						$mail->isHTML(true);

						$mail->Subject = $sub;

						$mail->Body    = $mes;	

					 	
					  if($_POST['author_mail'] && $_POST['reader_mail']){
					  	$my_data= "select * from users where active=1";
					  }else if($_POST['author_mail']){
					  	$my_data= "select * from users where active=1 AND reader=0 AND admin=0";
					  }else if($_POST['reader_mail']){
					  	$my_data= "select * from users where active=1 AND reader=1 AND admin=0";
					  }
						//$my_data= "select * from users where active=1";

						$data = $conn->query($my_data);

						$i = 0;

						while($row=$data->fetch_assoc()){					
							
							$mail->addAddress($row['email'], $row['name']);    
							// $mail->addAddress("shahrooz.devronix@gmail.com", "sharoz alam khan"); 
							$mail->send();  

							$mail->clearAllRecipients(); 

							// die("sak");



							if($i == 0)

							{

								$mail->addAddress("test.cloudweblabs@gmail.com", $row['name']);    

								$mail->send();

								$mail->clearAllRecipients();  

							}



							$i++;



						}



						$msg =  'Email has been sent';



					}



					catch (Exception $e) {

					}

					

				}else{

					if($_POST['author_mail']=='' || $_POST['reader_mail']==''){
						$msg='Select one option All Reader or All Author.';
					}
					if($_POST['message']){
						$msg='Message is required.';
					}
					if($_POST['subject']){
						$msg='Subject is required.';
					}

				}

				}

				?>





				<?php if($msg != ''){?><div class="text-center col-md-12"><h3><?php echo $msg;?></h3></div><?php } ?>



				<form method="post">



					<div class="form-group">



						<label for="subject">Subject</label>



						<input type="text" class="form-control" id="subject" name="subject" required>



					</div>



					<div class="form-group">



						<label for="message">Message</label>



						<textarea name="message" id="editor" required></textarea>



					</div>



					<div class="form-group">
	                    <input type="checkbox" checked  name="reader_mail">
	                    <label for="reader_mail"> All Reader</label>
	                </div>
	                <div class="form-group">
	                    <input type="checkbox" checked name="author_mail">
	                    <label for="author_mail"> All Author</label>
	                </div>



					<button type="submit" class="btn btn-default" name="email_send">Send</button>



				</form>	  



			</div>







		</div>



	</div>



















	<script>



		ClassicEditor



		.create( document.querySelector( '#editor' ) )



		.catch( error => {



			console.error( error );



		} );



	</script>



</body>



</html>



