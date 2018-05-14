<?php
$path = "/".$_REQUEST["folder"]."/";

$upload_directory = __DIR__ . "/../files/". basename($_FILES['files']['name']);

if (is_uploaded_file($_FILES['files']['tmp_name'])) {
	if (move_uploaded_file($_FILES['files']['tmp_name'], $upload_directory)) {
		echo basename($_FILES['files']['name']);
	} else {
		echo "Error: Este archivo no se guardó correctamente";
	}
}
else{
	echo "Error: Este archivo no se subió correctamente";
}
