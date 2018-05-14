<?php

require_once dirname(__FILE__) . "/bulletproof/src/bulletproof.php";

	
$image = new Bulletproof\Image($_FILES);

$path = $_REQUEST["folder"];
$image->setLocation(__DIR__ . "/../images/".$path);

if($image["pictures"]){
    $upload = $image->upload(); 
    
    if($upload){
        echo $upload->getName().".".$upload->getMime(); // uploads/cat.gif
    }else{
        echo $image["error"]; 
    }
}