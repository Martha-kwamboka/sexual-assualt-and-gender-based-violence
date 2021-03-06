<?php
session_start();
$id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];
$servername = "localhost";
$username = "root";
$password = "";
$database = "crime";
$table_reports = "tb_reports";
$mysql_obj = new mysqli($servername, $username, $password, $database);
if ($mysql_obj->connect_error) {
	die("connection failed:" . $mysql_obj->connect_error);
}
$td = "";
$report_id = $_REQUEST['id'];
$sql = "SELECT * FROM tb_reports WHERE id=$report_id";
$results = $mysql_obj->query($sql);
$row = $results->fetch_assoc();
$id = $row['id'];
$messages = $row['messages'];
$email = $row['email'];
$type = $row['type'];
$img_path = $row['img_path'];
if (!empty($img_path)) {
	$xx = explode(".", $img_path);
	$file = "../$img_path";
	if ($xx[1] == 'mp4' || $xx[1] == 'wma') {
		$td = "
	        <video width='360' height='300' controls>
                <source id='video' src='$file' type='video/mp4'>
                Your browser does not support the video tag.
	        </video>";
	} else {
		$td = "<img id='image' height='230px' src='$file' />";
	}
} else {
	$td = "";
}

$region_id = $row['region_id'];
$district_id = $row['district_id'];
$ward_id = $row['ward_id'];
$progress = $row['progress'];
$incident_area = $row['incident_area'];
$date_time = $row['date_time'];
$sql_region = "SELECT name FROM tb_region WHERE id='$region_id'";
$result_region = $mysql_obj->query($sql_region);
while ($row = $result_region->fetch_assoc()) {
	$region_name = $row['name'];
}
$sql_district = "SELECT * FROM tb_district WHERE id='$district_id'";
$result_district = $mysql_obj->query($sql_district);
while ($row = $result_district->fetch_assoc()) {
	$district_name = $row['name'];
}
$sql_ward = "SELECT * FROM tb_ward WHERE id='$ward_id'";
$result_ward = $mysql_obj->query($sql_ward);
while ($row = $result_ward->fetch_assoc()) {
	$ward_name = $row['name'];
}
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>Report Details</title>
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="shortcut icon" type="image/x-icon" href="../img/logo.ico" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link rel="stylesheet" type="text/css" href="../css/button.css" />
	<script src="https://kit.fontawesome.com/bf523026c9.js" crossorigin="anonymous"></script>
</head>

<body>
	<div id="main">
		<div id="header">
			<div id="logo">
				<div class="logo_img">
					<img src="../img/logo.png" alt="NPS Logo" height="auto" width="13%"></img>
					<div id="logo_text">
						<h1><a class="logo_colour" href="../index.php">KPS</a></h1>
						<h2>National Police Service</h2>
					</div>
				</div>
			</div>

			<div class="profile_info">
				<figure class="user_avatar"><img src="../img/admin_profile.png" width="5%">
					<span style="float: right;">
						<a href="../chat_box/chat_list.php"><i class="fa fa-2x fa-envelope"></i></a>
					</span>
				</figure>
				<div class="user_info">
					<?php if (isset($_SESSION['user'])) : ?>
						<strong><?php echo $_SESSION['user']['username']; ?></strong>
						<small style="font-size:15px">
							<i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
							&nbsp;
						</small>
					<?php endif ?>
				</div>
			</div>

			<div id="navbar">
				<nav>
					<ul id="menu">
						<li><a href="home.php">Home</a></li>
						<li class="selected"><a href="report.php">Report</a></li>
						<li style="float: right;"><a href="../contact.php">Contact Us</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div id="site_content">
			<div align="center" class="header">
				<h1>Report Details</h1>
			</div>
			<div id="content">
				<div align="center" id="wait" style="color: red;"></div>
				<div id="myModal" class="modal">
					<span class="close">&times;</span>
					<img class="modal-content" id="img01">
					<div id="caption"></div>
				</div>
				<table style="width:fit-content" class="form">
					<tr>
						<td style="width:70%">
							<table class="form">
								<tr>
									<td>Message</td>
									<td>:</td>
									<td><strong><?php echo $messages; ?></strong></td>
								</tr>
								<tr>
									<td>Progress</td>
									<td>:</td>
									<td><strong><?php echo $progress; ?></strong></td>
								</tr>
								<tr>
									<td>Type</td>
									<td>:</td>
									<td><strong><?php echo $type; ?></strong></td>
								</tr>
								<tr>
									<td>Area of Incidence</td>
									<td>:</td>
									<td><strong><?php echo $incident_area; ?></strong></td>
								</tr>
								<tr>
									<td>Location</td>
									<td>:</td>
									<td><strong><?php echo "$ward_name, $district_name - $region_name"; ?></strong>
									</td>
								</tr>
								<tr>
									<td>Date & time</td>
									<td>:</td>
									<td><strong><?php echo $date_time; ?></strong></td>
								</tr>

							</table>
						</td>
						<td>
							<?php echo $td; ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="footer">
			<a href="../login.php" id="logout">logout</a>
			<br><br>
			<p>Copyright &copy; Sexual Assault <?php echo date("Y"); ?> All Rights Reserved.</p>
		</div>
	</div>
	<!-- JAVASCRIPTS -->
	<script type="text/javascript" src="../js/_crime.js"></script>
</body>

</html>