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
	function login(){
		if(isset($_POST['submit'])){
			mysql_open();
			//	Validate username
      if(!empty($_POST['username'])){
				$username = mysql_real_escape_string(trim($_POST['username']));
      }else{
        $username = FALSE;
				echo '<div class="alert alert-warning alert-dismissable">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								You forgot to enter your <b>username</b>.
							</div>';
			}

			//	Validate password
			if(!empty($_POST['password'])){
				$password = mysql_real_escape_string(trim($_POST['password']));
			}else{
				$password = FALSE;
				echo '<div class="alert alert-warning alert-dismissable">
								<i class="fa fa-warning"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
								You forgot to enter your <b>password</b>.
							</div>';
			}

			if($username && $password){
				$sql = "SELECT * FROM user WHERE ((username='$username' || email='$username') AND password=password('$password')) LIMIT 1";
				$res = mysql_query($sql) or die(mysql_error());

				if(mysql_num_rows($res) == 1){
					$row = mysql_fetch_assoc($res);
					$_SESSION['id'] = $row['id'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['name'] = $row['name'];
					$_SESSION['date'] = $row['date'];
					$_SESSION['level'] = $row['level'];

					header("Location: ./");
					exit();
				}else{
					echo '<div class="alert alert-mod alert-danger alert-dismissable text-center">
									<i class="fa fa-warning"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
									<b>Username</b> dan <b>Password</b> tidak cocok. Silahkan coba lagi.
								</div>';
				}
			}
			mysql_close();
		}else if(isset($_SESSION['daftar'])){
			echo '<div class="alert alert-mod alert-success alert-dismissable text-center">
							<i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
							<b>Selamat</b>, anda telah berhasil terdaftar. Silahkan login.
						</div>';
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

    <title>Masuk</title>

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
						<a href="./" class="navbar-brand"><?php brand(); ?></a>
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
										<img src="img/1.png" class="img-circle" alt="User Image" />
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
				<form method="post" action="" class="form-signin" role="form">
					<?php login(); ?>
					<label for="inputEmail" class="sr-only">Username</label>
					<input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
					<label for="inputPassword" class="sr-only">Password</label>
					<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Masuk</button>
					<p class="text-muted">Belum punya akun...? <a href="daftar.php">Daftar</a></p>
					<a href="./" class="no-padding">Lupa Password</a>
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
