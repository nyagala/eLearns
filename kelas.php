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
									<li><a href="./">Home</a></li>
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
		if(isset($_GET['c']) AND $_GET['c'] > 0){
			mysql_open();

			$sql = "SELECT * FROM class WHERE id='".$_GET['c']."' LIMIT 1";
			$res = mysql_query($sql) or die(mysql_error());

			if(mysql_num_rows($res) == 1){
				$row = mysql_fetch_array($res);

				$sql_ = "SELECT * FROM user WHERE id='".$row['idTeacher']."' LIMIT 1";
				$res_ = mysql_query($sql_) or die(mysql_error());

				if(mysql_num_rows($res_) == 1){
					$row_ = mysql_fetch_array($res_);

					$teac .= '<a href="profile.php?u='.$row_['username'].'" class="thumbnail">
											<img src="img/'.$row['idTeacher'].'.png" width="100%">
										</a>
										<dl>
											<dt>Nama :</dt>
											<dd><small>'.$row_['name'].'</small></dd>
											<dt>Alamat :</dt>
											<dd><small>'.$row_['city'].'</small></dd>
											<dt>Email :</dt>
											<dd><small>'.$row_['email'].'</small></dd>
											<dt>Contact :</dt>
											<dd><small>'.$row_['phone'].'</small></dd>
										</dl>';

					$sql__ = "SELECT * FROM classD WHERE idClass='".$row['id']."'";
					$res__ = mysql_query($sql__) or die(mysql_error());

					if(mysql_num_rows($res__) > 0){
						$stud .= '<table class="table table-striped">
												<tbody>';
						while($row__ = mysql_fetch_array($res__)){
							$sql___ = "SELECT name FROM user WHERE id='".$row__['idStudent']."' LIMIT 1";
							$res___ = mysql_query($sql___) or die(mysql_error());

							if(mysql_num_rows($res___) == 1){
								$row___ = mysql_fetch_array($res___);
								$stud .= '<tr>
														<td width="5%">'.$i++.'</td>
														<td>'.$row___['name'].'</td>
													</tr>';
							}
						}
						$stud .= '	</tbody>
											</table>';
					}else{
						$stud .= '<div class="text-center text-muted">Pelajar masih kosong.</div>';
					}
				}

				echo '<div class="row">
								<div class="col-md-12">
									<div class="box box-solid box-primary">
										<div class="box-header">
											<i class="fa fa-book"></i>
											<h3 class="box-title">'.$row['name'].'</h3>
											<div class="box-tools pull-right margin-top">
												<i class="fa fa-clock-o"></i>&nbsp;
												'.tanggal($row['datetime']).' &nbsp; '.substr($row['datetime'],11,5).'
											</div>
										</div>
										<div class="box-body">
											<div class="row">
												<div class="col-xs-12 col-sm-6">
													<div class="col-md-4">													
														<h4 class="page-header">
															<i class="fa fa-user"></i>
															 &nbsp; Pengajar
														</h4>
														'.$teac.'
													</div>
													<div class="col-md-8">
														<div style="overflow:hidden; height:361px">
															<h4 class="page-header">
																<i class="fa fa-users"></i>
																&nbsp; Pelajar
															</h4>
															'.$stud.'
														</div>
														<div class="text-center">
															<hr>
															<button class="btn btn-primary btn-social btn-flat" onclick="javascript:alert(\'Under Construction\')">
																<i class="fa fa-users"></i>
																<span>&nbsp; Masuk ke kelas &nbsp;</span>
															</button>
														</div>													
													</div>
												</div>
												<div class="col-xs-12 col-sm-6">
													<br><br>
													<div id="map-canvas2"></div>													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>';
			}

			mysql_close();
		}else{
			header('Location: ./');
			exit();
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

    <title>Kelas</title>

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
				map = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions);
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
						<?php navigation(); ?>
					</div>
				</div>
			</nav>
    </header>

    <div class="container theme-showcase" role="main">
			<?php main(); ?>
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
