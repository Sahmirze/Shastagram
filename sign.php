<?php

session_start(); 
require "db.php";
if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['name'])){
$name=$_POST['name'];
$email=$_POST['email'];
$pass=$_POST['pass'];

  if($name !="" && $email !="" && $pass != ""){
	$sql='SELECT * FROM `sign` WHERE `email`="'.$email.'"';
	$result=mysqli_query($conn,$sql);
	echo ($sql);
	if(mysqli_num_rows($result)<=0){
		 $sql='INSERT INTO `sign` (`id`,`name`, `email`, `pass`) VALUES (NULL,"'.$name.'","'.$email.'","'.$pass.'")';
		 echo ($sql);
		 $result= mysqli_query($conn,$sql);
	 	 if ($result) {
		 $_SESSION['email']=$_POST['email'];
		 header('Location: index.php');
   		}
	}
     else $message="qeydiyyatdan kecmediniz email istifade olunub basqa emaille qeydiyatdan kecmeye calsin";
  }
  else $message="emaili ve passwordu bos saxlamaq olmaz ";
}
else $message=" ";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shastagram</title>
	<link rel="stylesheet" href="css/sign.css">
	<link rel="stylesheet" href="css/loginc.css">
	<link rel="icon" href="img/favicon.ico" />	
	<link rel="stylesheet" href="css/media-query.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
	 integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"><link rel="stylesheet"
	  href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
	 integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
	<div class="log-in-container">
		<div class="log-in">
			<img src="img/instagram-logo.png" class="logo" />
			<h2 class="qeydi txtcenter mbot10 fnwgt">Sign up to see photos and videos from your friends.</h2>
			<div class="facebook mbot10 pd10 wdt100 txtcenter fnwgt"> <a class="wdt100" href="https://www.facebook.com/login.php">
				<i class="fab fa-facebook-square"></i>
				<span>Log in with Facebook</span>
			</a>
			</div> 
			<span class="or-divider mr10">OR</span>
				<form  class="log-in-form" method="POST">
				 <input class="mr10" type="email" name="email" placeholder="Email" />
				 <input class="mr5" type="text" name="name" placeholder="FullName" />
				<input type="password" class="mr5" name="pass" placeholder="Password" />
				<input type="submit" name="" class="log-in-button" value="Sign in">	
				<p style="text-align:center; color:red; font-size:1.3em"><?php
				echo $message;
				?></p>
			</form>
			
		 <p class="txtcenter ftsiz">By signing up, you agree to our Terms , Data Policy and Cookies Policy .</p>
			
		</div>
		<div class="sign-up">
			<span>Have an	 account?</span><a href="loginc.php">Login in</a>
		</div>
		<div class="get-the-app">
			<span>Get the app</span>
			<div class="app-images">
				<a href=""><img src="img/app.png" /></a>
				<a href=""><img src="img/google.png" /></a>
			</div>
		</div>
	</div>
	</div>
</body>
</html>