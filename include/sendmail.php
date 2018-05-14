<?php

function sendMail($email, $username, $password, $firstname, $lastname){
// Multiple recipients
$to = $email;

// Subject
$subject = 'Primer ingreso portal Gemar';

// Message
$message = '
<html>
<head>
  <title>Estimado '.$firstname.' '.$lastname.',</title>
</head>
<body>
    <p>Se le ha generado una cuenta de acceso al <a href="www.gemar.cl">portal Gemar</a></p>
    <p>Su usuario de ingreso es: '.$username.'</p>
    <p>Y su contraseña: '.$password.'</p>
    <p>Diríjase a www.gemar.cl para ingresar</p>
    <p>Éste mail ha sido generado automáticamente, porfavor no responder.</p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type:text/html; charset=UTF-8';

// Additional headers
$headers[] = 'From: Servicio Técnico Gemar <servicio@gemar.com>';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));
}