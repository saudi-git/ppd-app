<?php
	$conn = mysqli_connect("localhost", "root", "root", "db_sfms");
	// $conn = mysqli_connect("localhost", "root", "", "db_sfms");
	// $conn = mysqli_connect("sql211.epizy.com", "epiz_33822298", "irnqVwStxJOGjSx", "epiz_33822298_mpwfile123");
	
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
	
?>