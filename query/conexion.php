<?php
	 // include the configs / constants for the database connection
	include_once dirname(__FILE__)."/../config/db.php";

    // create a database connection, using the constants from config/db.php (which we loaded in index.php)
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // change character set to utf8 and check it
    $con->set_charset("utf8");
	
    //if theres an error with the connection
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
?>