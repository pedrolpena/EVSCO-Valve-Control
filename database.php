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
<!--This is the page in which one can view the contents of the database in a view-only mode. There is also an option to edit-->
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
			#clear{
				color:white;
				background-color:white;
			}
			li{
				display:inline;
			}
		</style>
	</head>
	<body>
<!--this database page is view-only-->
		<div data-role="page" >
			<div align="center" class="heads" data-role="header"><h1>Port Database</h1></div>
			<div align="center" data-role="main">
				<p>View Only</p>
				<ul>
					<li>
<!--these are "back to home" and edit options for the user (edit meaning edit the information within the database)-->
						<a href="index.php"><button type="button">Back to Home</button></a>
						<a href="edit_database.php"><button type="button">Edit</button></a>
					</li>
				</ul>
				<hr id="clear">
				<?php
//this opens a connection with the database and then creates the table
					$db = new SQLite3("/var/www/portLocations.db");
					$result= $db->query("SELECT * FROM port_locations");
					$products=array();
					echo "<table><tr><th>Port Name</th><th>Latitude</th><th>Longitude</th><th>Radius</th></tr>";
					while($res=$result->fetchArray(SQLITE3_ASSOC)){
						echo "<tr><td>". $res['port_name'] . "</td><td>" . $res['lat']."</td><td>". $res['lon']. "</td><td>" . $res['radius'].  "</td></tr>";
					}
				?>
			</div>
			<div align="center" class="tails" data-role="footer"> IP of NOAA</div>
		</div>
	</body>
</html>
