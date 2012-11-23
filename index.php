<!--  NNN  OOOOOOOOO    AAAAA      AAAAA
NNNN  NNN  OOOOOOOOO   AAA AAA    AAA AAA
NNNNN NNN  OOO   OOO  AAA   AAA  AAA   AAA
NNNNNNNNN  OOO   OOO  AAAAAAAAA  AAAAAAAAA
NNN NNNNN  OOO   OOO  AAA   AAA  AAA   AAA
NNN  NNNN  OOOOOOOOO  AAA   AAA  AAA   AAA
NNN   NNN  OOOOOOOOO  AAA   AAA  AAA   -->

<!DOCTYPE html>
<htmllang="en">
	<head>
		<!--<script src="/home/pi/programs/valveproject/jquery.mobile-1.4.5.js" type="text/javascript"></script>
		<script src="/home/pi/programs/valveproject/jquery.mobile-1.4.5.min.js" type="text/javascript"></script>
		<script src="/home/pi/programs/valveproject/jquery-1.11.3.min.js" type="text/javascript"></script>-->
		<meta charset="UTF-8"></meta>
		<title>Port Valve Control</title>
		<style>
			.heads{
				background-color:grey;
				color:white;
			}
			.tails{
				background-color:grey;
				color:white;
			}
		</style>
	</head>
	<body>
		<div data-role="page" id="page1" align="center">
			<div data-role="header" class="heads">
				<h1>Port Valve Control</h><br>
			</div>
			<div data-role="main" id="main">
<!-- This is a form that opens and closes the valve-->
				<form method="GET" action="index.php" >
					<button type="submit" id="valveOpen" name="valveOpen" class="ui-btn ui-btn-inline">Open</button>
					<button type="submit" id="valveClose" name="valveClose" class="ui-btn ui-btn-inline">Close</button>
				</form>
				<p>For valve status, press Open or Close</p>
				<?php
					$status="Press Open or Close";
//This is a block that opens the valve if the open form button is pressed. It also relays the status of the valve.
					if(isset($_GET['valveOpen'])){
						$output=shell_exec("/usr/bin/python /home/pi/programs/open.py");
						$status="Open";
						$hello="<h3>Valve Status: " . $status . "</h3>";
						echo $hello;
					}
//This is a block that closes the valve is the Close button is pressed. It also relays the status of the valve.
					if(isset($_GET['valveClose'])){
						shell_exec("/usr/bin/python /home/pi/programs/close.py");
						$status="Closed";
						$hello="<h3>Valve Status: " . $status . "</h3>";
						echo $hello;
					}
				?>
<!--These buttons redirect to the database pages-->
				<br>
				<a href="database.php" class"ui-btn ui-btn-inline"><button type="button">View Ports</button></a>
				<a href="edit_database.php" class"ui-btn ui-btn-inline"><button type="button">Edit Ports</button></a>
			</div>
			<div class="tails" align="center" data-role="footer">
				<p>IP of NOAA</p>
			</div>
		</div>
	</body>
</html>
