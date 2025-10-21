<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y sanitizar los datos
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sekuydesign@gmail.com';
            $mail->Password   = 'iqpjkfubtbcevaoo';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Destinatarios
            $mail->setFrom('sekuydesign@gmail.com', 'José Gago');
            $mail->addAddress('sekuydesign@gmail.com');
            $mail->addReplyTo($email, $name);

            // Contenido
            $mail->isHTML(false);
            $mail->Subject = 'Nuevo mensaje desde tu portfolio';
            $mail->Body    = "Nombre: $name\nCorreo: $email\n\nMensaje:\n$message";

            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'invalid';
    }
} else {
    http_response_code(403);
    echo 'forbidden';
}
