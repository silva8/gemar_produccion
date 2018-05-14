<?php

require_once dirname(__FILE__) . '/conexion.php';
require_once dirname(__FILE__) . '/../include/lib.php';

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once dirname(__FILE__) . '/../libraries/password_compatibility_library.php';
}

function insertUser($username, $password, $email, $titulo, $role, $firstname, $lastname, $phone, $region, $disciplina) {
    global $con;


    $passhash = password_hash($password, PASSWORD_DEFAULT);
    $hexa = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

    $query = "INSERT INTO `cge30764_gemar`.`users`  VALUES (NULL, '$username', '$passhash', '$email', '$role', '$phone', '$region', '$titulo', '$disciplina', 'default.jpg', '$hexa', '$firstname', '$lastname')";
  
    if ($result = $con->query($query)) {
        //sendMail($email, $username, $password, $firstname, $lastname); 
        return $con->insert_id;
     } 
     else {
        return $con->error;
    }
}

echo insertUser($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['titulo'], $_REQUEST['role'], $_REQUEST['firstname'], $_REQUEST['lastname'], $_REQUEST['phone'], $_REQUEST['region'], $_REQUEST['disciplina']);
?>
