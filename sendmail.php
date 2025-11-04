<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- Cargar PHPMailer ---
require __DIR__ . '/phpmailer/src/Exception.php';
require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/SMTP.php';

// --- Cargar configuración privada ---
$configPath = __DIR__ . '/../.smtp-config.php'; // un nivel arriba de public_html
if (!file_exists($configPath)) {
    http_response_code(500);
    echo "<script>alert('Error: Falta configuración SMTP.'); history.back();</script>";
    exit;
}
require $configPath;

// --- Sanitizar entrada ---
function clean($v){ return trim(strip_tags($v)); }

$honeypot = $_POST['website'] ?? '';
$nombre   = clean($_POST['nombre'] ?? '');
$email    = clean($_POST['email'] ?? '');
$telefono = clean($_POST['telefono'] ?? '');
$area     = clean($_POST['area'] ?? '');
$mensaje  = trim($_POST['mensaje'] ?? '');

// Anti-spam
if ($honeypot !== '') { http_response_code(200); exit; }

// Validaciones básicas
if ($nombre === '' || $email === '' || $mensaje === '') {
    echo "<script>alert('Completá nombre, email y mensaje.'); history.back();</script>";
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('El email no es válido.'); history.back();</script>";
    exit;
}

// --- Envío de correo ---
$mail = new PHPMailer(true);

try {
    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host       = $SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = $SMTP_USER;
    $mail->Password   = $SMTP_PASS;
    $mail->SMTPSecure = $SMTP_SECURE;
    $mail->Port       = $SMTP_PORT;

    // Datos del correo
    $mail->setFrom($SMTP_USER, 'Web Infolex');
    $mail->addAddress($CONTACT_TO, 'Infolex');
    $mail->addReplyTo($email, $nombre);

    $mail->Subject = "[INFOLEX WEB] Nueva consulta" . ($area ? " - $area" : "");
    $mail->Body    = "Nueva consulta desde el sitio Infolex:\n\n"
                    . "Nombre: $nombre\n"
                    . "Email: $email\n"
                    . "Teléfono: $telefono\n"
                    . "Área: " . ($area ?: "No indicado") . "\n\n"
                    . "Mensaje:\n$mensaje\n\n"
                    . "-----\nEnviado: " . date('d/m/Y H:i');

    $mail->CharSet = 'UTF-8';

    $mail->send();
    echo "<script>alert('¡Gracias! Tu consulta fue enviada correctamente.'); window.location.href='index.html#contacto';</script>";

} catch (Exception $e) {
    error_log("Error al enviar correo: " . $mail->ErrorInfo);
    echo "<script>alert('Hubo un error al enviar. Intentalo nuevamente o contactanos por WhatsApp.'); window.location.href='index.html#contacto';</script>";
}
?>
