<?php

require_once "../modelos/Usuario.php";

require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsuarioController {

    public function registrar() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];

            $password = password_hash(
                $_POST["password"],
                PASSWORD_DEFAULT
            );

            $usuario = new Usuario();

            if ($usuario->buscarCorreo($correo)) {

                echo json_encode([
                    "success" => false,
                    "mensaje" => "El correo ya existe"
                ]);

                return;
            }

            // TOKEN de verificación
            $token = bin2hex(random_bytes(32));

            if ($usuario->registrar(
                $nombre,
                $correo,
                $password,
                $token
            )) {

                // ==========================
                // ENVIAR CORREO DE VERIFICACIÓN
                // ==========================
                $mail = new PHPMailer(true);

                try {

                    $link = "https://biot-ecommerce.biotransformo.com/verificar.php?token=". $token;

                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = true;

                    $mail->Username = "biottienda@gmail.com";
                    $mail->Password = "amtn zoyx axpc jwfg";

                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom("biottienda@gmail.com", "BioTransformo");
                    $mail->addAddress($correo);

                    $mail->isHTML(true);

                    $mail->Subject = "Verifica tu cuenta - BioTransformo";

                    $mail->Body = "
                        <h2> Bienvenido a BioTransformo</h2>
                        <p>Gracias por registrarte.</p>
                        <p>Haz clic en el boton para verificar tu cuenta:</p>

                        <a href='$link'
                           style='display:inline-block;
                                  padding:12px 20px;
                                  background:#28a745;
                                  color:white;
                                  text-decoration:none;
                                  border-radius:8px;'>
                            Verificar cuenta
                        </a>
                    ";

                    $mail->send();

                } catch (Exception $e) {
                    // si falla el correo igual deja registrar usuario
                }

                echo json_encode([
                    "success" => true,
                    "mensaje" => "Usuario registrado. Revisa tu correo para verificar tu cuenta."
                ]);

            } else {

                echo json_encode([
                    "success" => false,
                    "mensaje" => "Error al registrar"
                ]);
            }
        }
    }

    public function iniciarSesion() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $correo = $_POST["correo"];
            $password = $_POST["password"];

            $usuarioModel = new Usuario();

            $usuario = $usuarioModel->login($correo);

            if (!$usuario) {

                echo json_encode([
                    "success" => false,
                    "mensaje" => "Correo no encontrado"
                ]);

                return;
            }

            // VERIFICACIÓN DE CUENTA
            if ($usuario["verificado"] == 0) {

                echo json_encode([
                    "success" => false,
                    "mensaje" => "Debes verificar tu correo antes de iniciar sesión"
                ]);

                return;
            }

            if (password_verify($password, $usuario["password"])) {

                session_start();

                $_SESSION["id"] = $usuario["id"];
                $_SESSION["nombre"] = $usuario["nombre"];
                $_SESSION["correo"] = $usuario["correo"];
                $_SESSION["rol"] = $usuario["rol"];

                echo json_encode([
                    "success" => true,
                    "mensaje" => "Bienvenido " . $usuario["nombre"]
                ]);

            } else {

                echo json_encode([
                    "success" => false,
                    "mensaje" => "Contraseña incorrecta"
                ]);
            }
        }
    }
}

?>