<?php require_once('Connections/ibus.php'); ?>
<?php
error_reporting(0);
mysql_select_db($database_ibus, $ibus);
$route = $_REQUEST['route'];
$name = $_REQUEST['name'];
$seats = $_REQUEST['capacity'];
$key = $_REQUEST['key'];
$bus_id = $_REQUEST['busid'];

if($key=="bus")
{
$query1="SELECT * FROM busses WHERE bus_name='$name'";
$result1 = mysql_query($query1,$ibus);
$rows = mysql_num_rows($result1);
if($rows>="1")
{
echo "Bus Already Exists";
}
else
{
$query="INSERT INTO busses(no_of_seats,bus_name,route_id) VALUES('$seats','$name','$route')";
$result = mysql_query($query,$ibus);
if($result)
{echo "New Bus Added Successfully";}
}	
}
else if($key=="delbus")
{
$query="DELETE FROM busses WHERE bus_id='$bus_id'";
$result = mysql_query($query,$ibus);
if($result)
{
	echo "<div class='features' id='delresult'>
                        <section>
                        <h3>Add New Bus</h3>
									<span class='icon major fa-bus'></span>
							
                                 <form method='POST' name='addbus' id='addbus'>
										<div class='field'>
											<label for='name'>Bus Name</label>
											<input type='text' name='name' id='name' required/>
										</div>
										<div class='field'>
											<label for='numofseats'>Number of Seats</label>
											<input type='text' name='numofseats' id='numofseats' required/>
										</div>
										<div class='field'>
											<label for='message'>Route</label>";

$result = mysql_query("SELECT * FROM route", $ibus);
echo "<select class='form-control' name='routeid' id='routeid'>"; 
echo "<option value=''></option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['route_id'];
	$name=$row['route_name'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>
	
										</div>
										<ul class='actions'>
		<li><button type='button' onClick='addbusses()' class='button submit' id='add' name='add'>Add Bus</button></li>
                             
										</ul>
                                 </form>
                                   
							</section>
                            
                        
	<section>
                            <h3>Delete Bus Details</h3>
									<span class='icon major fa-bus'></span>
							
                                  <table class='alt'>
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
</table>
</section>
</div>
";
	
	}	
}
else if($key=="acc")
{
$query1="SELECT * FROM accomodations WHERE accomodation_name='$name'";
$result1 = mysql_query($query1,$ibus);
$rows = mysql_num_rows($result1);
if($rows>="1")
{echo "Accomodation Already Exists";}
else
{
$query="INSERT INTO accomodations(capacity,accomodation_name,accomodation_route_id) VALUES('$seats','$name','$route')";
$result = mysql_query($query,$ibus);
if($result)
{echo "<div class='features' id='delresult'>
                        <section>
                        <h3>Add New Accomodation</h3>
									<span class='icon major fa-home'></span>
									 <form method='POST'  name='addacc' id='addacc'>
										<div class='field'>
											<label for='accname'>Accomodation Name</label>
											<input type='text' name='accname' id='accname' required/>
										</div>
										<div class='field'>
											<label for='capacity'>Capacity</label>
											<input type='text' name='capacity' id='capacity' required/>
										</div>
										<div class='field'>
											<label for='message'>Route</label>";

$result = mysql_query("SELECT * FROM route", $ibus);
echo "<select class='form-control' name='routeid' id='routeid'>"; 
echo "<option value=''></option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['route_id'];
	$name=$row['route_name'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>

										</div>
										<ul class='actions'>
		<li><button type='button' onClick='addaccomodation()' class='button submit' id='add' name='add'>Add Accomodation</button></li>
           
										</ul>
									</form>
							</section>
                            <section>
                            <h3>Delete Accomodation Details</h3>
									<span class='icon major fa-home'></span>
								
                                  <table class='alt'>
								  <thead>
									<tr>
													<th>Accomodation Name</th>
													<th>Capacity</th>
													<th>Route</th>
													<th>Delete</th>
									</tr>
											</thead>
											<tbody>";
		$result6 = mysql_query("SELECT * FROM accomodations", $ibus);

while($row5 = mysql_fetch_array($result6)) {
	$accomodation_id=$row5['accomodation_id'];
	$accomodation_name = $row5['accomodation_name'];
	$capacity = $row5['capacity'];
	$route_id = $row5['accomodation_route_id'];

$result7 = mysql_query("SELECT * FROM route WHERE route_id='$route_id'", $ibus);
	$row = mysql_fetch_assoc($result7 );	
	$route_name = $row['route_name'];
	
		
											echo"
												<tr>
													<td>".$accomodation_name."</td>
													<td>".$capacity."</td>
													<td>".$route_name."</td>
                                                     <td> <a onClick='delete_acc(".$accomodation_id.")' class='btn btn-success btn-xs'><i class='fa fa-times'></i></a></td>
												</tr>";
}
echo"</tbody>
</table>

							</section>
							</div>
";
}
}	
}
else if($key=="delacc")
{
$query="DELETE FROM accomodations WHERE accomodation_id='$bus_id'";
$result = mysql_query($query,$ibus);
if($result)
{
	echo "<div class='features' id='delresult'>
                        <section>
                        <h3>Add New Accomodation</h3>
									<span class='icon major fa-home'></span>
									 <form method='POST'  name='addacc' id='addacc'>
										<div class='field'>
											<label for='accname'>Accomodation Name</label>
											<input type='text' name='accname' id='accname' required/>
										</div>
										<div class='field'>
											<label for='capacity'>Capacity</label>
											<input type='text' name='capacity' id='capacity' required/>
										</div>
										<div class='field'>
											<label for='message'>Route</label>";

$result = mysql_query("SELECT * FROM route", $ibus);
echo "<select class='form-control' name='routeid' id='routeid'>"; 
echo "<option value=''></option>";
while ($row = mysql_fetch_assoc($result)){
	$id= $row['route_id'];
	$name=$row['route_name'];
	
	echo "<option value=$id>$name</option>";
	}
	echo "</select>

										</div>
										<ul class='actions'>
		<li><button type='button' onClick='addaccomodation()' class='button submit' id='add' name='add'>Add Accomodation</button></li>
           
										</ul>
									</form>
							</section>
                            <section>
                            <h3>Delete Accomodation Details</h3>
									<span class='icon major fa-home'></span>
								
                                  <table class='alt'>
								  <thead>
									<tr>
													<th>Accomodation Name</th>
													<th>Capacity</th>
													<th>Route</th>
													<th>Delete</th>
									</tr>
											</thead>
											<tbody>";
		$result6 = mysql_query("SELECT * FROM accomodations", $ibus);

while($row5 = mysql_fetch_array($result6)) {
	$accomodation_id=$row5['accomodation_id'];
	$accomodation_name = $row5['accomodation_name'];
	$capacity = $row5['capacity'];
	$route_id = $row5['accomodation_route_id'];

$result7 = mysql_query("SELECT * FROM route WHERE route_id='$route_id'", $ibus);
	$row = mysql_fetch_assoc($result7 );	
	$route_name = $row['route_name'];
	
		
											echo"
												<tr>
													<td>".$accomodation_name."</td>
													<td>".$capacity."</td>
													<td>".$route_name."</td>
                                                     <td> <a onClick='delete_acc(".$accomodation_id.")' class='btn btn-success btn-xs'><i class='fa fa-times'></i></a></td>
												</tr>";
}
echo"</tbody>
</table>

							</section>
							</div>
";
	
	}	
}
else if($key=="route")
{
$query1="SELECT * FROM route WHERE route_name='$name'";
$result1 = mysql_query($query1,$ibus);
$rows = mysql_num_rows($result1);
if($rows>="1")
{echo "Route Already Exists";}
else
{
$query="INSERT INTO route(route_name) VALUES('$name')";
$result = mysql_query($query,$ibus);
if($result)
{echo "New Route Added Successfully";}
}	
}
else if($key=="delroute")
{
$query="DELETE FROM route WHERE route_id='$bus_id'";
$result = mysql_query($query,$ibus);
if($result)
{
	echo "<div class='features' id='delresult'>
                        <section>
                        <h3>Add New Route</h3>
                        <br>
                        <br>
									<span class='icon major fa-home'></span>
									<form method='post' action='#' name='addroute'>
										<div class='field'>
											<label for='routename'>Route Name</label>
											<input type='text' name='routename' id='routename' required/>
										</div>
										
										<ul class='actions'>
											<li><button type='button' onClick='addroutes()' class='button submit' id='add' name='add'>Add Route</button></li>
										</ul>
									</form>
							</section>
                            <section>
                            <h3>Delete Route Details</h3>
                            <br>
                        
									<span class='icon major fa-home'></span>
									
                                  <table class='alt'>
								  <thead>
									<tr>
													<th>Route</th>
													<!--<th>Delete</th>-->
									</tr>
											</thead>
											<tbody>";
		$result6 = mysql_query("SELECT * FROM route", $ibus);

while($row5 = mysql_fetch_array($result6)) {
	$route_id=$row5['route_id'];
	$route_name = $row5['route_name'];
	
		
											echo"
												<tr>
													<td>".$route_name."</td>
  <!--<td> <a onClick='delete_route(".$route_id.")' class='btn btn-success btn-xs'><i class='fa fa-times'></i></a></td>--->
												</tr>";
}
echo"</tbody>
</table>

	
							</section>
							</div>";
	
	}	
}
else if($key=="time")
{
$query1="SELECT * FROM bus_timing WHERE time='$name'";
$result1 = mysql_query($query1,$ibus);
$rows = mysql_num_rows($result1);
if($rows>="1")
{echo "Bus Time Already Exists";}
else
{
$query="INSERT INTO bus_timing(time) VALUES('$name')";
$result = mysql_query($query,$ibus);
if($result)
{echo "New Bus Time Added Successfully";}
}	
}
?>



