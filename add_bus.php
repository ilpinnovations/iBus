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
		<title>iBus | Add Bus</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
         <link rel="stylesheet" type="text/css" href="pace.css">    
     <script src="pace.js"></script>
        <script>
        function addbusses()
{
	var capacity=document.getElementById('numofseats').value;
	var name=document.getElementById('name').value;
	var route=document.getElementById('routeid').value;
if (window.XMLHttpRequest)
{// co'1de for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		alert(xmlhttp.responseText);
   

    }
  }
xmlhttp.open("GET","insert_data.php?name="+name+"&capacity="+capacity+"&route="+route+"&key=bus",true);
xmlhttp.send();
}

function delete_bus(str)
{
var result=confirm("Do you really want to delete this Bus?");
if(result)
{	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
   alert('Bus Deleted Successfully');
   document.getElementById("delresult").innerHTML = xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","insert_data.php?busid="+str+"&key=delbus",true);
xmlhttp.send();
}
}

        </script>
	</head>
	<body>

		<!-- Sidebar-->
			<section id="sidebar">
            
				<div class="inner">
                <h1>iBus</h1>
					<nav>
						<ul>
							<?php if (isset($_SESSION['MM_Username'])): ?>
                            <li><a href="welcome.php#intro">Dashboard</a></li>
                            <li><a href="welcome.php#three">Upload Employee Details</a></li>
                            <li><a href="welcome.php#two">Bus Management</a></li>
                             <li><a href="index.php">Home</a></li>
                            <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
                            <?php else: ?>
                            <li><a href="welcome.php#intro">Dashboard</a></li>
                            <li><a href="welcome.php#three">Upload Employee Details</a></li>
                            <li><a href="welcome.php#two">Bus Management</a></li>
                             <li><a href="index.php">Home</a></li>
                           <li><a href="login.php">Login</a></li>
                            <?php endif ?>
						</ul>
					</nav>
				</div>
			</section>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Intro -->
					<section id="intro" class="wrapper style1 fullscreen fade-up">
                
						<div class="inner">
							<h2>Welcome <?php echo $emp_name ?></h2>
                            <hr>
                            
                            <section>
						<div class="features" id="delresult">
                        <section>
                        <h3>Add New Bus</h3>
									<span class="icon major fa-bus"></span>
							
                                 <form method="POST" name="addbus" id="addbus">
										<div class="field">
											<label for="name">Bus Name</label>
											<input type="text" name="name" id="name" required/>
										</div>
										<div class="field">
											<label for="numofseats">Number of Seats</label>
											<input type="text" name="numofseats" id="numofseats" required/>
										</div>
										<div class="field">
											<label for="message">Route</label>
<?php
$result = mysql_query("SELECT * FROM route", $ibus);
echo "<select class='form-control' name='routeid' id='routeid'>"; 
echo "<option value=''></option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['route_id'];
	$name=$row['route_name'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>";
	?>
										</div>
										<ul class="actions">
		<li><button type="button" onClick="addbusses()" class="button submit" id="add" name="add">Add Bus</button></li>
                             
										</ul>
                                 </form>
                                   
							</section>
                            
                            <section>
                            <h3>Delete Bus Details</h3>
									<span class="icon major fa-bus"></span>
							<?php
                                  echo "<table class='alt'>
								  <thead>
									<tr>
													<th>Bus Name</th>
													<th>Seats</th>
													<th>Route</th>
													<th>Delete</th>
									</tr>
											</thead>
											<tbody>";
		$result6 = mysql_query("SELECT * FROM busses", $ibus);

while($row5 = mysql_fetch_array($result6)) {
	$bus_id=$row5['bus_id'];
	$bus_name = $row5['bus_name'];
	$capacity = $row5['no_of_seats'];
	$route_id = $row5['route_id'];

$result7 = mysql_query("SELECT * FROM route WHERE route_id='$route_id'", $ibus);
	$row = mysql_fetch_assoc($result7 );	
	$route_name = $row['route_name'];
	
		
											echo"
												<tr>
													<td>".$bus_name."</td>
													<td>".$capacity."</td>
													<td>".$route_name."</td>
                 <td> <a onClick='delete_bus(".$bus_id.")' class='button submit'><i class='fa fa-times'></i></a></td>
												</tr>";
}
echo"</tbody>
</table>";
?>
							</section>
                            
							</div>
                          <h3>Note</h3>
									<ul class="alt">
						<li>Route A : Blue Star Residency -> Hotel Lee Frank -> Nikumjam Apartments -> Scarlet Circle</li>
						<li>Route B : Desai Homes -> Green Apartments -> Orchid Regency -> Siva Pooja</li>
						<li>Route C : Karuna Apartments -> Srivinayaka Tourist Home</li>
											</ul>
						</section>
						</div>
					</section>
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
