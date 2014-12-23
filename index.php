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

	/*	Fixed top navigation bar	*/
	function navigation(){
		if(isset($_SESSION['id'])){
			mysql_open();

			$sql = "SELECT * FROM user WHERE id='".$_SESSION['id']."' LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());

			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_array($res);
				
				echo ' <ul class="nav navbar-nav">										
									<li><a href="redline.php">Redline</a></li>
									<li><a href="timeline.php">Timeline</a></li>
									<li><a href="buatkelas.php">Buat Kelas</a></li>
									<li><a href="referensi.php">Referensi</a></li>
									<li class="active"><a href="./">Home</a></li>
								</ul>
								<ul class="nav navbar-nav navbar-right">
									<li class="dropdown user user-menu">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											<i class="glyphicon glyphicon-user"></i>
											<span>'.$row['username'].' <i class="caret"></i></span>
										</a>
										<ul class="dropdown-menu">
											<li class="user-header">
												<img src="img/'.$row['id'].'.png" class="img-circle" alt="User Image" />
												<p>
													'.$row['name'].'
													<small>Member sejak &nbsp; '.tanggal($row['date']).'</small>
												</p>
											</li>
											<li class="user-footer">
												<div class="pull-left">
													<button class="btn btn-info btn-flat" onclick="window.location=\'profile.php?u='.$row['username'].'\'">Profile</button>
												</div>
												<div class="pull-right">
													<button class="btn btn-danger btn-flat" onclick="window.location=\'?!=keluar\'">Keluar</button>
												</div>
											</li>
										</ul>
									</li>
								</ul>';
			}
		}else{
			echo '<ul class="nav navbar-nav navbar-right">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="glyphicon glyphicon-user"></i>
									<span>Tamu <i class="caret"></i></span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="img/0.png" class="img-circle" alt="User Image" />
										<p>
											Anonymous
										</p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<button class="btn btn-default btn-flat" onclick="window.location=\'daftar.php\'">Daftar</button>
										</div>
										<div class="pull-right">
											<button class="btn btn-default btn-flat" onclick="window.location=\'masuk.php\'">Masuk</button>
										</div>
									</li>
								</ul>
							</li>
						</ul>';
		}
	}
	function main(){
		mysql_open();
		
		$sql = "SELECT * FROM class ORDER BY datetime DESC";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) > 0){
			echo '<div class="row">';
			while($row = mysql_fetch_array($res)){
				echo '<div class="col-sm-6 col-md-4">
								<div class="box box-solid box-primary">
									<div class="box-header">
										<h3 class="box-title">'.substr($row['name'],0,24).'</h3>
										<div class="box-tools pull-right no-padding no-margin">
											<button class="btn btn-mod btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat" onclick="window.location=\'kelas.php?c='.$row['id'].'\'">
												<i class="fa fa-external-link"></i>
											</button>
										</div>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-xs-6 border-right">
												<div class="text-center">
													<p>'.tanggal($row['datetime']).'</p>
													<h3 class="no-margin">'.substr($row['datetime'],11,5).'</h3>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="text-center">
													<h3>'.substr($row['location'],0,11).'</h3>
												</div>
											</div>
										</div>
										<br>
										<p>Kapasitas : '.$row['quota'].' orang</p>
										<div class="progress md progress-striped no-margin">
											<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="'.$row['filled'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$row['filled'].'%;">
												<span class="sr-only">'.$row['filled'].'% Complete</span>
											</div>
										</div>
									</div>							
								</div>
							</div>';
			}
			echo '</div>';
		}else{
			echo '<div class="callout callout-info">
							<p>Tidak ada kelas yang tersedia. <a href="buatkelas.php">Buat kelas</a></p>
						</div>';
		}
		
		mysql_close();
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

    <title>Home</title>

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
						<?php navigation(); ?>
					</div>
				</div>
			</nav>
    </header>

    <div class="container theme-showcase" role="main">
			<section class="content">
				<?php main(); ?>				
			</section>
		</div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		<script src="js/jquery-2.1.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
			$(function () { $("[data-toggle='tooltip']").tooltip(); });
		</script>
	</body>
</html>
<?php ob_flush(); ?>
