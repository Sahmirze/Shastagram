<?php
session_start();
   require "db.php";  
   
   $mesaj="";
if (isset($_POST['email']) && isset($_POST['pass'])){
  if($_POST['email'] !="" && $_POST['pass']!=""){
     $sql='SELECT * FROM `sign` WHERE `email`="'.$_POST['email'].'" AND `pass`="'.$_POST['pass'].'"';
    echo $sql;
     $result=mysqli_query($conn,$sql);
     if (mysqli_num_rows($result)>0){
         $_SESSION['email'] = $_POST['email'];
          header("Location: index.php");
      }
       else $mesaj="Istifadeci adini ve parolunu dogru daxil edin";
   }
  
  else $mesaj="Emaili ve parolu bos saxlamaq olmaz";

}
else $mesaj="";

if(isset($_REQUEST['lang']) && is_numeric($_REQUEST['lang'])){
  $lang=$_REQUEST['lang'];
  setcookie('lang', $lang, time() + (86400 * 30), "/");
}elseif  ( isset($_COOKIE['lang']) ) $lang = $_COOKIE['lang'];
else{
  $lang=3;
  setcookie('lang', $lang, time() + (86400 * 30), "/");
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shatagram</title>
    <link rel="stylesheet" href="css/loginc.css" />
    <link rel="stylesheet" href="css/media-query.css" />
    <link rel="icon" href="img/favicon.ico" />
  </head>
  <body>
    <main>
      <div class="log-in-container">
        <form action="" method="GET">
          <select name="lang" class="slc-bc" onchange="submit()">
          <option value="">Select Language</option>
          <?php
          $sql = 'SELECT `id`,`name` FROM `language` WHERE `status`=1';
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              if($row['id'] == $lang) $slc="selected"; else $slc="";
              echo '<option '.$slc.' value="'.$row["id"].'">'.$row["name"].'</option> '."<br/>".'';
            }
          }
          ?>
          </select>
        </form>

        <div class="log-in">
          <img src="img/instagram-logo.png" class="logo" />
       
						<form action="" class="log-in-form" method="POST">
             <input type="email" name="email" placeholder="Email" />
            <input type="password" name="pass" placeholder="Password" />
            <input type="hidden" name="name" />
            <input type="submit" name="" class="log-in-button wd-100" value="Log in">	
            <p style="text-align:center; font-size:1.3em; color:red"><?=$mesaj?></p>
						</form>
         
          <span class="or-divider">OR</span>
          <div class="fb-login">
            <a href="https://www.facebook.com/login.php">
              <img src="img/facebook-icon.png" />
              <span>Log in with Facebook</span>
            </a>
          </div>
          <a href="">Forgot password?</a>
        </div>
        <div class="sign-up">
          <span>Don't have an account?</span><a href="sign.php">Sign up</a>
        </div>
        <div class="get-the-app">
          <span>Get the app</span>
          <div class="app-images">
            <a href=""><img src="img/app.png" /></a>
            <a href=""><img src="img/google.png" /></a>
          </div>

        </div>
      </div>
      <div class="d-flex psreal">
     
        <img src="img/phone.png"/>
				<span class="slide"><img src="" alt="" name="img" ></span>
     
      </div>
      
    </main>
		<script>
let arr=['1.jpg','2.jpg','3.jpg','4.jpg']
let i=0
function slider(){
	document.img.src="img/" + arr[i]
	if(i<arr.length-1){
			i++
	}
	else {
		i=0
	}
	setTimeout(slider,5000)
}
onload=slider

		</script>
  </body>
</html>