<?php
session_start();
$id = $_SESSION['user']['id'];
$_username = $_SESSION['user']['username'];
$servername = "localhost";
$username = "root";
$password = "";
$database = "crime";
$table_reports = "tb_reports";
$mysql_obj = new mysqli($servername, $username, $password, $database);
if ($mysql_obj->connect_error) {
	die("connection failed");
}
$j = 1;
$td = "";
$sql = "SELECT * FROM tb_reports";
$results = $mysql_obj->query($sql);
while ($row = $results->fetch_assoc()) {
	$id = $row['id'];
	$messages = $row['messages'];
	$email = $row['email'];
	$type = $row['type'];
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
	$td .= "<tr>
			<td>$j</td>
			<td>$messages</td>
			<td>$incident_area</td>
			<td>$ward_name</td>
			<td>$district_name</td>
			<td>$region_name</td>
			<td>$date_time</td>
			<td>$progress</td>
			<td><a style='background-color:#43423f;cursor:pointer' href='report_details.php?id=$id'>Details</a></td>
			</tr>";
	$j++;
}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>List of Reports</title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="shortcut icon" type="image/x-icon" href="../img/logo.ico" />
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
							<li><a href="create_user.php">add user</a></li>
							<li class="selected"><a href="report.php">Reports</a></li>
						</ul>
					</nav>
				</div>
			</div>
			<div id="site_content" class="content">
				<div align="center" class="header">
					<h1>Report list</h1>
				</div>
				<div id="wait"></div>
				<div id="content">
					<input type="text" placeholder="Search..." style="width:25%;" id="input"
						oninput="search_in_table()">
					<table class="report_list" border="0" id="table">
						<tr>
							<th>s/n</th>
							<th>Message</th>
							<th>Incident Area</th>
							<th>Ward</th>
							<th>District</th>
							<th>Region</th>
							<th>Date time</th>
							<th>Progress</th>
						</tr>
						<?php echo $td; ?>
					</table>
					</>
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