
		<?php
		require "db.php";

		session_start();
		if ( !isset($_SESSION['email'])  ||  $_SESSION['email']=="" ) header('Location: loginc.php'); 


		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Shastagram</title>
			<link rel="stylesheet" href="css/style.css">
			<link rel="icon" href="img/favicon.ico" />
			<link rel="stylesheet" href="css/upload.css">
			<link rel="stylesheet" href="css/reset.css">
			<link rel="stylesheet" href="css/modal.css">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
			<script src="https://cdn.tiny.cloud/1/w1isolnpf1qqolaghurieom5wjtfym59k0ue9glbm341881f/tinymce/5/tinymce.min.js" 
			referrerpolicy="origin"></script>
		</head>
		<body>
		<div class="container">
			<script>
		tinymce.init({
		selector: 'textarea',  // change this value according to your HTML
		extended_valid_elements : 'mycustomblock[id],mycustominline',
		custom_elements : 'mycustomblock,~mycustominline' // Notice the ~ prefix to force a span element for the element
		});
			</script>
			<header>
				<?php
				$sql='SELECT * FROM `sign` WHERE `email`="'.$_SESSION['email'].'"';
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
				while (  $row = mysqli_fetch_assoc($result)){
					echo '<p>'.$row['name'].'</p>';
				}
				
				}
				?>

				<nav>
					
					<div class="logo flex_item pd-top"><img src="img/i-logo.png" class="img" alt="instagram logo"></div>
					<div class="psstick wd-100 pd-8 white">
						<ul class="d-flex list jusc">
							<li class="flex-center"><a href="index.php"><i class="fas fa-home"></i></a></li>
							<li><div class='file file--upload' >
							<button onclick="ac()"><i class="fas fa-plus-circle black cr-point"  ></i></button>
						
							
						</div>
							<li class="flex-center"><a href="loginc.php"><i class="fas fa-user"></i> Login</a></li>
						</ul>
					</div>
				</nav>
			</header>
			
			<?php

		$sql='SELECT * FROM `sign` WHERE `email`="'.$_SESSION['email'].'"';
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);


		if(isset($_FILES['image']) && !empty($_FILES['image']) ){
		$dir="img/";
		$extention=['jpg','jpeg','png'];
		$size=1024*1024;
		$time;

		$text=$_POST['text'];
		foreach ($_FILES["image"]["tmp_name"] as $key => $value) {
			if(!empty($_FILES["image"]["tmp_name"][$key])){
				$image_name= $_FILES["image"]["name"][$key];
				$image_temp = $_FILES["image"]["tmp_name"][$key];
				$image_path = "img/" . $_FILES["image"]["name"][$key];   
				$image_size = $_FILES["image"]["size"][$key];
				$image_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
				$check = getimagesize($image_temp);
				if($check == false )
				{
					echo' <script>
					alert("BU FAYL OLMAZ")
					</script>';
				}
				elseif (file_exists($image_path)) {
					echo' <script>
					alert("bu sekil a;rtiq var")
					</script>';
				} 
				elseif ($image_size>$size) {
					echo ' <script>
					alert("bu sekil seklin olcusu boyukdur")
					</script>';
				}
				else{

				
				move_uploaded_file($image_temp,$image_path);
				$time=date('Y-m-d') .time();

		$sql='INSERT INTO `post`(`id`, `name`, `user`, `date`, `image`, `text`) VALUES (NULL,"'.$row['name'].'","'.$row['id'].'","'.$time.'","'.$image_name.'","'.$text.'")';
		$result=mysqli_query($conn,$sql);
		}
			}

		}	

		}
			?>	
		<?php
			
		$sql='SELECT DISTINCT `name`,`user`,`date`, `text` FROM `post` ORDER BY `date` DESC';
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
			
			?>
			<main>
			<section class="sct mrgn">
			<div class="head d-flex both_jusc ">
			<div class="user d-flex">
			<img class="userimg" src="img/user.png" alt="user"> 
			<div class="flex-center"><?=$row['name']?></div>
			</div>
			<div class="flex-center fs-19 point">
			<p>...</p>
			</div>
			</div>

			<?php	
			$sql2='SELECT * FROM `post` WHERE `date`="'.$row['date'].'" AND `user`="'.$row['user'].'"';
			$result2=mysqli_query($conn,$sql2);
			if(mysqli_num_rows($result2)==1){ 
				while($row2 = mysqli_fetch_assoc($result2)){
					$arr[]=$row2['image'];

					?>
					<div class="post">
					<img class="postimage" src="img/<?=$row2['image']?>" alt="">
					</div>
					<?php

				} 
			} 
			?>
		
			
			<?php
			if(mysqli_num_rows($result2)>1){ 
				$arr=[];
				?>
				<div id="slider">
            <button onclick="sol()" class="btn"> ⏴ </button>
				<?php
				while($row2 = mysqli_fetch_assoc($result2)){
					$arr[]=$row2['image'];

					?>
					<?php

				} ?>
				
				<button onclick="sag()" class="btn"> ⏵ </button>    
				</div>
				<script>
					let arr=<?php print_r($arr)?>
				
					let slider = document.getElementById("slider")
						x=0
					deyis()    
					function sol(){
						if(x>0)x--
						else x=arr.length-1
						deyis()
					}
					function sag(){
						if(x<arr.length )x++
						else x=0
						deyis()
					}
					
					function deyis(){
						for (let key in arr) {
						slider.style.background=`url('img/+ ${key[x]}') center/cover`
							}
							
					}
			 	</script>
				<?php
			}
			?>
			
			<?php
			?>
			<div class="usermessage ">
			<p ><i><?=$row['name']?></i></p>
			<p class="usermessage"><?=$row['text']?></p>
		</div>
		</section>
			</main>
			<?php

			} 
		}
		?>










		</div>
		<div class="modal" id="modal">
			
			<div class="button"><button onclick="bagla()">✕</button></div>	
			<form action=""  method="POST"  enctype="multipart/form-data" >
			<p class="txt-center"><label for="text" >Metni Daxil Et</label><br><textarea name="text" id="text" ></textarea></p>	
			<p><label for="file" class="file2">Add image <i class="fas fa-upload"></i></label><br><input type="file" name="image[]" id="file" multiple accept=".jpg,.jpeg,.png"></p>	
			<p><input type="submit" value="Share" class="submit" onclick="refresh()" ></p>
			</form>

			</div>
		<script>
			function  refresh() {
				location.href="index.php";
			}

			function ac(){
			document.getElementById("modal").style.display = "block";	
			}
		function bagla(){
			document.getElementById("modal").style.display = "none";	

		}
		</script>
		</body>
		</html>