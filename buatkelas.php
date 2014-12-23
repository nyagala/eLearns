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

	function main(){
		if(!isset($_SESSION['id'])){
			header('Location: ./');
			exit();
		}else{
			if(isset($_POST['submit'])){
				mysql_open();
				
				$name = mysql_real_escape_string(trim($_POST['name']));
				$datetime = mysql_real_escape_string(trim($_POST['date'])).' '.mysql_real_escape_string(trim($_POST['time']));
				$quota = mysql_real_escape_string(trim($_POST['quota']));
				$location = mysql_real_escape_string(trim($_POST['location']));
				$address = mysql_real_escape_string(trim($_POST['address']));

				$sql = "INSERT INTO class VALUES (NULL,'".$_SESSION['id']."','$name','$datetime','$location','$address','$quota',0)";
				$res = mysql_query($sql) or die(mysql_error());

				if(mysql_affected_rows() == 1){
					echo '<br>
								<div class="alert alert-mod alert-success alert-dismissable no-margin">
									<i class="fa fa-check"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button>
									Kelas telah berhasil dibuat. <a href="kelas.php?c='.(mysql_insert_id()).'">Lihat kelas</a>
								</div>';
				}
				
				mysql_close();
			}
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

    <title>Buat Kelas</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Bootstrap date Picker -->
    <link href="css/bootstrap-datepicker.css" rel="stylesheet"/>
    <!-- Bootstrap time Picker -->
    <link href="css/bootstrap-timepicker.min.css" rel="stylesheet"/>
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

		<!-- Google Map API	-->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
			var geocoder;
			var map;
			function initialize() {
				geocoder = new google.maps.Geocoder();
				var latlng = new google.maps.LatLng(-6.9026003, 107.6187131);
				var mapOptions = {
					zoom: 15,
					center: latlng
				}
				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			}

			function codeAddress() {
				var address = document.getElementById('address').value;
				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
								map: map,
								position: results[0].geometry.location
						});
					}
				});
			}

			google.maps.event.addDomListener(window, 'load', initialize);
    </script>
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
							<li><a href="redline.php">Redline</a></li>
							<li><a href="timeline.php">Timeline</a></li>
							<li class="active"><a href="buatkelas.php">Buat Kelas</a></li>
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
			<section class="content">
				<form method="post" action="" class="form-create" role="form">
					<?php main(); ?>
					<div class="row">
						<div class="col-md-12">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-book"></i>
								</span>
								<input class="form-control" type="text" name="name" placeholder="Materi" required>
							</div>
						</div>
					</div>					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-5">
									<div class="bootstrap-datepicker">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<input class="form-control datepicker" type="date" name="date" placeholder="Tanggal" required>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="bootstrap-timepicker">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</span>
											<input class="form-control timepicker" type="time" name="time" placeholder="Jam" required>											
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="bootstrap-timepicker">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-group"></i>
											</span>
											<input class="form-control" type="number" name="quota" placeholder="Kapasitas" required>											
										</div>
									</div>
								</div>
							</div>
						</div>							
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-location-arrow"></i>
								</span>
								<input class="form-control" type="text" name="location" placeholder="Lokasi" required>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-home"></i>
								</span>
								<input class="form-control" type="text" name="address" id="address" onkeypress="codeAddress()" placeholder="Alamat" required>										
							</div>
						</div>
					</div>
					<br>
					<button class="btn btn-default pull-right" name="submit">Submit</button>
					<br><br><hr>
					<div class="row">
						<div class="col-sm-12">
							<div id="map-canvas"></div>
						</div>
					</div>
				</form>				
			</section>			
		</div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		<script src="js/jquery-2.1.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- bootstrap date picker -->
    <script src="js/bootstrap-datepicker.js"></script>
    <!-- bootstrap time picker -->
    <script src="js/bootstrap-timepicker.min.js"></script>
    <!-- Page script -->
    <script type="text/javascript">
			$(function() {
				//	Datepicker
				$(".datepicker").datepicker({
					showInputs: false,
					format: 'yyyy-mm-dd'
				});
				//	Timepicker
				$(".timepicker").timepicker({
					showInputs: false,					
					showMeridian: false									
				});
			});
		</script>
	</body>
</html>
<?php ob_flush(); ?>
