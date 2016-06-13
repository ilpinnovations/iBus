<?php require_once('Connections/ibus.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_ibus, $ibus);
$query_Recordset1 = sprintf("SELECT * FROM employees WHERE ct_reference='$colname_Recordset1'");
$Recordset1 = mysql_query($query_Recordset1, $ibus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$ctrefno= $row_Recordset1['ct_reference'];
$emp_name= $row_Recordset1['employee_name'];
$emp_id= $row_Recordset1['employee_id'];
$lg= $row_Recordset1['lg'];
$stream= $row_Recordset1['stream'];
$batch= $row_Recordset1['batch'];
$role= $row_Recordset1['role'];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>iBus | Welcome</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
        <link rel="stylesheet" type="text/css" href="pace.css">    
     <script src="pace.js"></script>
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Sidebar -->
			<section id="sidebar">
				<div class="inner">
					<nav>
                    <h1>iBus</h1>
						<ul>
                         <?php if (isset($_SESSION['MM_Username'])): ?>
                         <?php if ($role == "Employee"): ?>
                            <li><a href="#dash2">Dashboard</a></li>
							<li><a href="#bookseat">Book Seat</a></li>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
                            <?php else: ?>
                            <li><a href="#intro">Dashboard</a></li>
                            <li><a href="#three">Upload Employee Details</a></li>
                            <li><a href="#two">Bus Management</a></li>
                             <li><a href="index.php">Home</a></li>
                            <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
                             <?php endif ?>
                            
                            <?php else: ?>
                             <?php if ($role == "Employee"): ?>
                            <li><a href="#dash2">Dashboard</a></li>
							<li><a href="#bookseat">Book Seat</a></li>
                            <li><a href="index.php">Home</a></li>
                           <li><a href="login.php">Login</a></li>
                            <?php else: ?>
                            <li><a href="#intro">Dashboard</a></li>
                            <li><a href="#three">Upload Employee Details</a></li>
                            <li><a href="#two">Bus Management</a></li>
                             <li><a href="index.php">Home</a></li>
                           <li><a href="login.php">Login</a></li>
                             <?php endif ?>  
                          <?php endif ?>
						</ul>
					</nav>
				</div>
			</section>

		<!-- Wrapper -->
			<div id="wrapper">
 <?php if ($role == "Admin"): ?>
 <!-- Intro -->
					<section id="intro" class="wrapper style1 fullscreen fade-up">
						<div class="inner">
							<h2>Welcome <?php echo $emp_name ?></h2>
                            <hr>
                            <section>
                             <ul class="actions">
										<li><a href="#" class="button">Download Booking Data</a></li>
									</ul>
						<div class="features">
                        <section>
                        <h3>Evening Statistics</h3>
									<span class="icon major fa-bus"></span>
									<h3>Total Bookings : 100</h3>
                                  <table class="alt">
											<tbody>
												<tr>
													<td>Routes</td>
													<td>A</td>
													<td>B</td>
                                                    <td>C</td>
												</tr>
                                                <tr>
													<td>Bookings</td>
													<td>56</td>
													<td>34</td>
                                                    <td>89</td>
												</tr>
												<tr>
													<td>Busses Required</td>
													<td>2</td>
													<td>3</td>
                                                    <td>4</td>
												</tr>
												
											</tbody>
											</table>
							</section>
                            <section>
                            <h3>Morning Statistics</h3>
									<span class="icon major fa-bus"></span>
									<h3>Total Bookings : 100</h3>
                                  <table class="alt">
											<tbody>
												<tr>
													<td>Routes</td>
													<td>A</td>
													<td>B</td>
                                                    <td>C</td>
												</tr>
                                                <tr>
													<td>Bookings</td>
													<td>56</td>
													<td>34</td>
                                                    <td>89</td>
												</tr>
												<tr>
													<td>Busses Required</td>
													<td>2</td>
													<td>3</td>
                                                    <td>4</td>
												</tr>
												
											</tbody>
											</table>
							</section>
								<section>
									<span class="icon major fa-bus"></span>
									<h3>Total Bookings : 100</h3>
                                    
									<h3>Time : 07:30AM</h3>
                                  <table class="alt">
											<tbody>
												<tr>
													<td>Routes</td>
													<td>A</td>
													<td>B</td>
                                                    <td>C</td>
												</tr>
                                                <tr>
													<td>Bookings</td>
													<td>56</td>
													<td>34</td>
                                                    <td>89</td>
												</tr>
												<tr>
													<td>Busses Required</td>
													<td>2</td>
													<td>3</td>
                                                    <td>4</td>
												</tr>
												
											</tbody>
											</table>
							</section>
							
                            
								<section>
									<span class="icon major fa-bus"></span>
									<h3>Total Bookings : 100</h3>
                                    
									<h3>Time : 07:00AM</h3>
                                  <table class="alt">
											<tbody>
												<tr>
													<td>Routes</td>
													<td>A</td>
													<td>B</td>
                                                    <td>C</td>
												</tr>
                                                <tr>
													<td>Bookings</td>
													<td>56</td>
													<td>34</td>
                                                    <td>89</td>
												</tr>
												<tr>
													<td>Busses Required</td>
													<td>2</td>
													<td>3</td>
                                                    <td>4</td>
												</tr>
												
											</tbody>
											</table>
								</section>
							</div>
                           
						</section>
						</div>
					</section>
                    <!-- Three -->
					<section id="three" class="wrapper style1-alt">
						<div class="inner">
                        <h2>Upload Employee Details</h2>
                        <hr>
                        <div class="features">
                        <section>
                        
									<span class="icon major fa-file"></span>
                                    <h3>Select File</h3>
                                     </br></br>
									<form name="import" method="post" enctype="multipart/form-data">
                       
    	<input type="file" class="button special"  name="filea" accept=".csv"/><br /><br /><br />
        <input type="button" class="button submit"  onClick="uploaddata1()" name="submit1" value="Upload" />
</form>
							</section>
                            <section>
                        
									<span class="icon major fa-file"></span>
									<h3>CSV Format</h3>
                                    </br></br>
                                  <ul class="actions fit">
										<li><a href="#" class="button special fit">Download Format</a></li>
									</ul>
							</section>
                            </div>
						</div>
                       
					</section>
<!-- Two -->
					<section id="two" class="wrapper style1 fade-up">
						<div class="inner">
							<h2>Bus Management</h2>
							<div class="features">
								<section>
									<span class="icon major fa-bus"></span>
									<h3>Add Bus</h3>
									<p><ul class="actions">
											<li><a href="add_bus.php" class="button submit">Add Bus</a></li>
										</ul></p>
								</section>
								<section>
									<span class="icon major fa-home"></span>
									<h3>Add Accomodation</h3>
									<p><ul class="actions">
											<li><a href="add_accomodation.php" class="button submit">Add Accomodation</a></li>
										</ul></p>
								</section>
								<section>
									<span class="icon major fa-road"></span>
									<h3>Add Route</h3>
									<p><ul class="actions">
											<li><a href="add_route.php" class="button submit">Add Route</a></li>
										</ul></p>
								</section>
								<section>
									<span class="icon major fa-clock-o"></span>
									<h3>Manage Bus Timing</h3>
									<p><ul class="actions">
											<li><a href="add_timing.php" class="button submit">Manage</a></li>
										</ul></p>
								</section>
                                <section>
									<span class="icon major fa-road"></span>
									<h3>Bus Allocation</h3>
									<p><ul class="actions">
											<li><a href="allocate_bus.php" class="button submit">Allocate</a></li>
										</ul></p>
								</section>
							</div>
							
						</div>
					</section>
   <?php else: ?>
     <section id="dash2" class="wrapper style1 fullscreen fade-up">
						<div class="inner">
							<h2>Welcome <?php echo $emp_name ?></h2>
                            <hr>
                            <h3>Current Booking</h3>
                            <section>
						<div class="features">
                        <section>
                        
									<span class="icon major fa-book"></span>
									<h3>Evening at 07:30PM</h3>
                                  <table class="alt">
											<tbody>
												<tr>
													<td>From</td>
													<td>Peepal Park</td>
													
												</tr>
                                                <tr>
													<td>To</td>
													<td>Scarlet Circle</td>
												</tr>
																				
											</tbody>
											</table>
                                            <ul class="actions">
											<li><a href="" class="button submit">Cancel Booking</a></li>
										</ul>
							</section>
                            <section>
                          
									<span class="icon major fa-book"></span>
									<h3>Morning at 07:30AM</h3>
                                  <table class="alt">
											<tbody>
												<tr>
													<td>From</td>
													<td>Scarlet Circle</td>
													
												</tr>
                                                <tr>
													<td>To</td>
													<td>Peepal Park</td>
												</tr>
																				
											</tbody>
											</table>
                                            <ul class="actions">
											<li><a href="" class="button submit">Cancel Booking</a></li>
										</ul>
							</section>
                             <section>
                          
									<span class="icon major fa-times"></span>
									<h3>There are no current bookings</h3>
                                  
							</section>
								</div>
                           
						</section>
						</div>
					</section>
                    
<section id="bookseat" class="wrapper style1 fade-up">
						<div class="inner">
                        <h2>Book Seat</h2>
                        <hr>
						<div class="box alt">
						<div class="row uniform">
						<div class="12u$" align="center">
                       <div class="7u">
                      <section>
                      <form method="post" id="booking" name="booking" >
                      <br>
                      <span class="icon major fa-bus"></span>
									<h3>Select Time</h3>
                                  <div class="12u$">
												<div class="select-wrapper">
													
											
<?php
$result = mysql_query("SELECT * FROM bus_timing", $ibus);
echo "<select class='form-control' name='routeid' id='routeid'>"; 
echo "<option value=''></option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['bus_timimg_id'];
	$name=$row['time'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>";
	?>
										
												</div>
											</div>
                                            <br>
                                            
                                            <ul class="actions">
											<li><button type="button" onClick="addaccomodation()" class="button submit" id="add" name="add">Book Now</button></li>
										</ul>
                                         <br> <br> <br> <br>
                                         </form>
							</section>
                           </div>
                        </div>
                        </div>
                        </div>
						</div>
					</section>
   <?php endif ?> 
</div>

		<!-- Footer -->
			<footer id="footer" class="wrapper style1-alt">
				<div class="inner">
					<ul class="menu">
						<li>&copy; ILP Innovations</li>
					</ul>
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>