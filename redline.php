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

	if(!isset($_SESSION['id'])){
		header('Location: ./');
		exit();
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

    <title>Redline</title>

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
						<ul class="nav navbar-nav">							
							<li class="active"><a href="redline.php">Redline</a></li>
							<li><a href="timeline.php">Timeline</a></li>
							<li><a href="buatkelas.php">Buat Kelas</a></li>
							<li><a href="referensi.php">Referensi</a></li>
							<li><a href="./">Home</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="glyphicon glyphicon-user"></i>
									<span><?php echo $_SESSION['username']; ?> <i class="caret"></i></span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="img/<?php echo $_SESSION['id']; ?>.png" class="img-circle" alt="User Image" />
										<p>
											<?php echo $_SESSION['name']; ?>
											<small>Member sejak &nbsp; <?php echo tanggal($_SESSION['date']); ?></small>
										</p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<button class="btn btn-info btn-flat" onclick="window.location='profile.php?u=<?php echo $_SESSION['username']; ?>'">Profile</button>
										</div>
										<div class="pull-right">
											<button class="btn btn-danger btn-flat" onclick="window.location='?!=keluar'">Keluar</button>
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
			Under Construction
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
