<?php

// include the configs / constants for the database connection
require_once dirname(__FILE__) . "/../config/db.php";

// load the login class
require_once dirname(__FILE__) . "/../classes/Login.php";

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    //include("views/dashboard.php");
    echo true;
    
} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    header( "Location: ".dirname(__FILE__) ."/../index.php");
}
