<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación de los datos
    $name = filter_var(trim($_POST["contact_name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["contact_email"]), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST["contact_phone"]), FILTER_SANITIZE_STRING);
    $subject = filter_var(trim($_POST["contact_subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["contact_message"]), FILTER_SANITIZE_STRING);

    // Verificar que los campos no estén vacíos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Validar el formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no válido.";
        exit;
    }

    // Configuración del correo
    $to = "control.mgr@meccanikgroup.com"; // Cambia esto por tu dirección de correo
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $full_message = "Nombre: $name\n";
    $full_message .= "Correo: $email\n";
    $full_message .= "Teléfono: $phone\n";
    $full_message .= "Asunto: $subject\n\n";
    $full_message .= "Mensaje:\n$message\n";

    // Enviar el correo
    if (mail($to, $subject, $full_message, $headers)) {
        header("Location: contact.html");
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
