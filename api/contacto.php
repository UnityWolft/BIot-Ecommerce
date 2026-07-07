<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try{

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'biottienda@gmail.com';
    $mail->Password = 'amtn zoyx axpc jwfg';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(
        'biottienda@gmail.com',
        'BioTransformo'
    );

    $mail->addAddress(
        'biottienda@gmail.com'
    );

    $mail->Subject =
        "Contacto Web: " . $asunto;

    $mail->Body =
        "Nombre: $nombre\n\n" .
        "Correo: $correo\n\n" .
        "Mensaje:\n$mensaje";

    $mail->send();

    echo json_encode([
        "success" => true
    ]);

}catch(Exception $e){

    echo json_encode([
        "success" => false,
        "mensaje" => $mail->ErrorInfo
    ]);
}