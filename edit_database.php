<!--  NNN  OOOOOOOOO    AAAAA      AAAAA
NNNN  NNN  OOOOOOOOO   AAA AAA    AAA AAA
NNNNN NNN  OOO   OOO  AAA   AAA  AAA   AAA
NNNNNNNNN  OOO   OOO  AAAAAAAAA  AAAAAAAAA
NNN NNNNN  OOO   OOO  AAA   AAA  AAA   AAA
NNN  NNNN  OOOOOOOOO  AAA   AAA  AAA   AAA
NNN   NNN  OOOOOOOOO  AAA   AAA  AAA   -->

<!DOCTYPE html>
<html>
	<head>
<!--This is an editable version of the database. One can edit existing port information, add new information, and delete ports-->
		<meta charset="UTF-8">
		<title>Port Database</title>
		<style>
			.heads{
				background-color:grey;
				color:white;
			}
			.tails{
				bottom:0;
				position:fixed;
				width:100%;
				background-color:grey;
				color:white;
			}
			table, th, td {
				border: 1px solid black;
			}
			table{padding:10px;}
			#clear{
				color:white;
				background-color:white;
			}
			li{
				display:inline;
			}
			#subby{
				padding-bottom:20px;
				padding-top:10px;
			}
			#subbby{
				padding-bottom:20px;
			}
			#subbbby{
				padding-bottom:30px;
			}
		</style>
	</head>
	<body>
		<div data-role="page" >
			<div align="center" class="heads" data-role="header"><h1>Port Database</h1></div>
			<div align="center" data-role="main">
				<ul>
					<li>
						<a href="index.php"><button type="button">Back to Home</button></a>
						<a href="database.php"><button type="button">View Only</button></a>
					</li>
				</ul>
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
					<?php
//This file name needs to be changed accoring to the file's individual path on the computer.
						$db = new SQLite3("/var/www/portLocations.db");
						$result= $db->query("SELECT * FROM port_locations");
						$products=array();
						echo "<table><tr><th>Port Name</th><th>Latitude</th><th>Longitude</th><th>Radius (km)</th></tr>";
						while($res=$result->fetchArray(SQLITE3_ASSOC)){
//give each cell a name corresponding to the row number (the variable i in the next line)
							$i=$res['key'];
							$name="row" . $i;
							echo "<tr><td><input id='port_name" . $name . "' name='port_name" . $name . "' type='text' value='". $res['port_name'] . "'></input></td><td><input id='lat" . $name . "' name='lat" . $name . "' type='text' value='" . $res['lat']."'></input></td><td><input id='lon" . $name . "' name='lon" . $name . "' type='text' value='". $res['lon']. "'></input></td><td><input id='radius" . $name . "' name='radius" . $name . "' type='text' value='" . $res['radius'].  "'></input></td><td><input style='width:15%; height:15%' value='" . $i . "' name='delete" . $name . "' type='checkbox'></input></td></tr>";
//I'm trying to delete stuff, so these are variables that allow the if() below to work
							$updated="UPDATE port_locations SET de_lete='" . $i . "' WHERE key='" . $i . "'";
							$db->exec($updated);
//These are the posts for the exiting cells that will replace the current information
						}//end of while that creates table
						echo"<tr><td><input type='text' name='addPort' placeholder='Add Port'></input></td><td><input name='addLat' type='text' placeholder='Add Latitude'></input></td><td><input name='addLon' type'text' placeholder='Add Longitude'></input></td><td><input name='addRadius' type='text' placeholder='Add Radius'></input></td></tr>";
						echo"</table>";
//I am trying to update the database via the info in the text boxes
// These are the posts for the end boxes that will add a new port
						$ports="port_name" . $name;
						$port=$_POST[$ports];
						$lats="lat" . $name;
						$lat=$_POST[$lats];
						$lons="lon" . $name;
						$lon=$_POST[$lons];
						$radii="radius" . $name;
						$radius=$_POST[$radii];
						$newport= $_POST['addPort'];
						$newlat= $_POST['addLat'];
						$newlon= $_POST['addLon'];
						$newradius= $_POST['addRadius'];
//This adds a new row (whether or not the "add ---" is filled). I need to figure out how to limit it to only update if it is filled.
						if(isset($_POST['submitPorts'])){
							$testport=$_POST['addPort'];
							$testlat=$_POST['addLat'];
							$testlon=$_POST['addLon'];
							$testradius=$_POST['addRadius'];
//This is a form validation that does not allow empty boxes, special charactacters or spaces in the input
							if(empty($_POST['addPort'])){
								echo "<h3>Please Enter Information for all fields</h3>";
							}//end of if
							if(empty($_POST['addLat'])){
								echo "<h3>Please Enter Information for all fields</h3>";
							}//end of if
							if(empty($_POST['addLon'])){
								echo "<h3>Please Enter Information for all fields</h3>";
							}//end of if
							if(empty($_POST['addRadius'])){
								echo "<h3>Please Enter Information for all fields</h3>";
							}//end of if
							else{
								if(!is_numeric($testlat)){
									echo"<h3>Latitude entered was not numeric</h3>";
								}//end of if
								if(!is_numeric($testlon)){
									echo"<h3>Longitude entered was not numeric</h3>";
								}//end of if
								if(!is_numeric($testradius)){
									echo"<h3>Radius entered was not numeric</h3>";
								}//end of if
								if(!preg_match("/^[a-zA-Z.,+_-]+$/",$testport)){
									echo"<h3>Name must not contain spaces or special characters!</h3>";
								}//end of if
								else{
//This is where, after getting validated, the table actually gets updated and refreshed
									$db->exec("INSERT INTO port_locations (port_name, lat, lon, radius, de_lete) VALUES('$newport', '$newlat', '$newlon', '$newradius', '$i');");
									echo"<meta http-equiv='refresh' content='0'>";
								}
							}//end of else
						}//end of port submission
						if(isset($_POST['editPorts'])){
//This SHOULD replace the information within the db with the info in the form, but it just clears the cell in the database
							while($res=$result->fetchArray(SQLITE3_ASSOC)){
								$i=$res['key'];
								$name="row" . $i;
								$ports="port_name" . $name;
								$port=$_POST[$ports];
								$lats="lat" . $name;
								$lat=$_POST[$lats];
								$lons="lon" . $name;
								$lon=$_POST[$lons];
								$radii="radius" . $name;
								$radius=$_POST[$radii];
//This is a form validation that does not allow empty boxes, special charactacters or spaces in the input
								if(empty($port)){
									echo "<h3>Please Enter Information for all fields</h3>";
								}//end of if
								if(empty($lat)){
									echo "<h3>Please Enter Information for all fields</h3>";
								}//end of if
								if(empty($lon)){
									echo "<h3>Please Enter Information for all fields</h3>";
								}//end of if
								if(empty($radius)){
									echo "<h3>Please Enter Information for all fields</h3>";
								}//end of if
								else{
									if(!is_numeric($lat)){
										echo"<h3>Latitude entered was not numeric</h3>";
									}//end of if
									if(!is_numeric($lon)){
										echo"<h3>Longitude entered was not numeric</h3>";
									}//end of if
									if(!is_numeric($radius)){
										echo"<h3>Radius entered was not numeric</h3>";
									}//end of if
									if(!preg_match("/^[a-zA-Z.,+_-]+$/",$port)){
										echo"<h3>Name must not contain spaces or special characters!</h3>";
									}//end of if
									else{
//This is where, after getting validated, the table actually gets updated and refreshed
										$update="UPDATE port_locations SET port_name='" . $port . "' WHERE key='" . $i . "'";
										$update1="UPDATE port_locations SET lat='" . $lat . "' WHERE key='" . $i . "'";	
										$update2="UPDATE port_locations SET lon='" . $lon . "' WHERE key='" . $i . "'";
										$update3="UPDATE port_locations SET radius='" . $radius . "' WHERE key='" . $i . "'";
										$db->exec($update);
										$db->exec($update1);
										$db->exec($update2);
										$db->exec($update3);
										echo"<meta http-equiv='refresh' content='0'>";
									}//end of else
								}//end of else
							}//end of while


						}//end of port editing
//This section deletes the rows according to the checkboxes at the end of each row
						if(isset($_POST['deletePorts'])){
							while($res=$result->fetchArray(SQLITE3_ASSOC)){
								$i=$res['key'];
								$name="row" . $i;
								$delete="delete" . $name;
								$deleted=$_POST[$delete];
								echo"<h3>" . $name . "<h3>";
								echo"<h3>" . $delete . "<h3>";
								echo"<h3>" . $deleted . "<h3>";
								$db->exec("DELETE FROM port_locations WHERE de_lete='" . $deleted . "'");
								echo"<meta http-equiv='refresh' content='0'>";
							}//end of while
						}//end of delete
					?><!--end of php-->
					<ul>
						<li>
							<div id="subby"><button type="submit" name="submitPorts" id="submitter">Submit New Port</button></div>
							<div id='subbby'><button type='submit' name='editPorts' id='submitting'>Submit Changes to Ports</button></div>
							<button type="submit" name='deletePorts' id='deleter'>Delete Checked Ports</button>
						</li>
					</ul>
				</form>
			</div>
			<div align="center" class="tails" data-role="footer"> IP of NOAA</div>
		</div>
	</body>
</html>
