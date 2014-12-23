<?php include_once('inc/func.inc');
/*
 * index.php
 * 
 * Copyright 2014 Imancha <imancha_266@ymail.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

	/*	Login checking	*/
	function register(){
		if(isset($_POST['submit'])){			
			mysql_open();			

			//	Validate name 
			if(preg_match('/^[A-Za-z \'.-]{2,50}$/i', $_POST['name'])){
				$name = mysql_real_escape_string(trim($_POST['name']));
			}else{
				$name = FALSE;
				echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								Please enter your name.
							</div><br>';
			}
			// Validate username
			if(preg_match('/^\w{2,20}$/', $_POST['username'])){
				$username = mysql_real_escape_string(trim($_POST['username']));
			}else{
				$username = FALSE;
				echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								Please enter a valid username.
							</div><br>';
			}
			//	Validate password
			if(preg_match('/^\w{2,20}$/', $_POST['password'])){
				$password = mysql_real_escape_string(trim($_POST['password']));				
			}else{
				$password = FALSE;
				echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								Please enter a valid password.
							</div><br>';
			}
			//	Validate city
			if(!empty($_POST['city'])){
				$city = mysql_real_escape_string(trim($_POST['city']));
			}else{
				$city = FALSE;
				echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								Please fill your city.
							</div><br>';
			}
			//	Validate email
			if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
				$email = mysql_real_escape_string(trim($_POST['email']));
			}else{
				$email = FALSE;
				echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								Please enter a valid email address.
							</div><br>';
			}                                        
      //	Validate phone
      if(preg_match('/^[0-9 \' +-]{10,20}$/i', $_POST['phone'])){
				$phone = mysql_real_escape_string(trim($_POST['phone']));
			}else{
				$phone = FALSE;
				echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								Please enter your number phone.
							</div><br>';
			}
			//	Insert into database
			if($name && $username && $password && $email && $city && $phone){                            
				$sql = "SELECT username FROM user WHERE username=LOWER('$username') LIMIT 1";
				$res = mysql_query($sql) or die(mysql_error());

				if(mysql_num_rows($res) == 1){
					echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
									<i class="fa fa-warning"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
									Username tidak tersedia.
								</div><br>';
				}else{
					$sql = "SELECT email FROM user WHERE email='".$email."' LIMIT 1";
					$res = mysql_query($sql) or die(mysql_error());

					if(mysql_num_rows($res) == 1){
						echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
										<i class="fa fa-warning"></i>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
										Email sudah terdaftar.
									</div><br>';
					}else{
						$sql = "INSERT INTO user VALUES (NULL,'$username',password('$password'),'$name','$email','$city','$phone','member',now())";
						$res = mysql_query($sql) or die(mysql_error());

						if(mysql_affected_rows() == 1){							
							$_SESSION['daftar'] = rand()/getrandmax()*1.8-0.9;
							header('Location: ./masuk.php');
							exit();
						}
					}
				}				
			}
			mysql_close();
		}		
	}	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Daftar</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="css/ionicons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <header class="header">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="./" class="navbar-brand"><?php brand();?></a>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="glyphicon glyphicon-user"></i>
									<span>Tamu <i class="caret"></i></span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="img/0.png" class="img-circle" alt="User Image" />
										<p>Anonymous</p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<button class="btn btn-default btn-flat" onclick="window.location='daftar.php'">Daftar</button>
										</div>
										<div class="pull-right">
											<button class="btn btn-default btn-flat" onclick="window.location='masuk.php'">Masuk</button>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
    </header>
    
    <div class="container theme-showcase" role="main">			
			<section class="content">
				<form method="post" action="" class="form-signup" role="form">
					<?php register(); ?>
					<label for="inputName" class="sr-only">Nama</label>
					<input type="text" id="inputName" name="name" class="form-control" placeholder="Nama Lengkap" required autofocus>
					<label for="inputEmail" class="sr-only">Username</label>
					<input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required>
					<label for="inputPassword" class="sr-only">Password</label>
					<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
					<label for="inputEmail" class="sr-only">Email</label>
					<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required>					
					<label for="inputCity" class="sr-only">City</label>
					<input type="text" id="inputCity" name="city" class="form-control" placeholder="Kota" required>
					<label for="inputPhone" class="sr-only">Phone</label>
					<input type="text" id="inputPhone" name="phone" class="form-control" placeholder="Handphone" required>
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Daftar</button>
					<p class="text-muted">Sudah punya akun...? <a href="masuk.php">Masuk</a></p>
				</form>
			</section>      
		</div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->    
		<script src="js/jquery-2.1.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>    
	</body>
</html>
<?php ob_flush(); ?>
