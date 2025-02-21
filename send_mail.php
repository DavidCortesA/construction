<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var(trim($_POST["contact_name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["contact_email"]), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST["contact_phone"]), FILTER_SANITIZE_STRING);
    $subject = filter_var(trim($_POST["contact_subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["contact_message"]), FILTER_SANITIZE_STRING);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no válido.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Titan Email
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'control.mgr@meccanikgroup.com'; // Reemplaza con tu email de Titan
        $mail->Password = 'Meccanik.22'; // Reemplaza con tu contraseña de Titan
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
        $mail->Port = 465;

        // Configurar remitente y destinatario
        $mail->setFrom('control.mgr@meccanikgroup.com', 'Tu Nombre');
        $mail->addAddress('control.mgr@meccanikgroup.com'); // Cambia esto por el destinatario

        // Configuración del correo
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "Nombre: $name\nCorreo: $email\nTeléfono: $phone\nAsunto: $subject\n\nMensaje:\n$message\n";

        // Enviar correo
        if ($mail->send()) {
            header("Location: contact.html");
            echo "Mensaje enviado correctamente.";
        } else {
            echo "Error al enviar el mensaje.";
        }
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Acceso no permitido.";
}
?>
