<?php
include('config.php');
$my_data= "select * from users";

$data= mysqli_query($conn,$my_data);

$array = array();

while($row=$data->fetch_assoc()){
      
	  
	    $array[] = $row;
	    $name=$row['name']; 
	    $email=$row['email'];
	    $admin= $row['admin'];
		$password= $row['password'];
		$verified= $row['verified'];
		$active= $row['active'];
	    $email_token= $row['email_token'];
        $remember_token= $row['remember_token'];
		$created_at = $row['created_at'];
	    $updated_at = $row['updated_at'];
}

echo "<pre>";
print_r($array);

?>





























<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Form</title>
<link href="css/bootstrap.css" />
</head>



<body>
</body>
</html>
