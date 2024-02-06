<?php
/**
 * @version 1.0
 */

require("class.phpmailer.php");
require("class.smtp.php");

// Valores enviados desde el formulario
if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["comments"]) || !isset($_POST["subject"])) {
    die("Es necesario completar todos los datos del formulario");
}

$nombre = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$mensaje = $_POST["comments"];


$smtpHost = "keep";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "keep";  // Mi cuenta de correo
$smtpClave = "keep";  // Mi contraseña

// Email donde se enviaran los datos cargados en el formulario de contacto
$emailDestino = "keep";

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->IsHTML(true);
$mail->CharSet = "utf-8";


// VALORES A MODIFICAR //
$mail->Host = $smtpHost;
$mail->Username = $smtpUsuario;
$mail->Password = $smtpClave;

$mail->From = $email; // Email desde donde envío el correo.
$mail->FromName = $nombre;
$mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario

$mail->Subject = "WebPage contact Perley-tem =>  $subject"; // Este es el titulo del email.
$mensajeHtml = nl2br($mensaje);
$mail->Body = "<hr /> Email: {$email} <br /> <hr />{$mensajeHtml} <br /> <br /> <hr />"; // Texto del email en formato HTML
$mail->AltBody = "{$mensaje} \n\n"; // Texto sin formato HTML
// FIN - VALORES A MODIFICAR //


$log_message = "[" . date('Y-m-d H:i:s') . "] Formulario de contacto enviado por: $name\n";
$log_message .= "Name  :    $name\n";
$log_message .= "e-mail:    $email\n";
$log_message .= "Subject:   $subject\n";
$log_message .= "Comments:  $mensaje\n";
$log_message .= "===========================================================\n";

// Apéndice al log con un mensaje informativo
file_put_contents("./contactInfo.log", $log_message, FILE_APPEND);



$estadoEnvio = $mail->Send();
if ($estadoEnvio) {
    //        echo "El correo fue enviado correctamente.";  NOTA No puede haber un echo antes del header
    header("Location: MessageOk.html");

    //    exit();

} else {
    echo "Error !";
}
