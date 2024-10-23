<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $servicio = $_POST['servicio'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $descripcion = $_POST['descripcion'];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'vihpasmo06@gmail.com'; // Cambia esto por el servidor SMTP de tu proveedor de correo
        $mail->SMTPAuth = true;
        $mail->Username = 'vihpasmo06@gmail.com'; // Tu correo
        $mail->Password = 'marvin06.'; // Tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('vihpasmo06@gmail.com', 'MediHelp');
        $mail->addAddress('vihpasmo06@gmail.com', 'MediHelp');

        $mail->isHTML(true);
        $mail->Subject = 'Nueva Solicitud de Servicio';
        $mail->Body = "<h3>Detalles de la Solicitud de Servicio</h3>
                        <p><strong>Nombre del Paciente:</strong> $nombre</p>
                        <p><strong>Servicio:</strong> $servicio</p>
                        <p><strong>Teléfono:</strong> $telefono</p>
                        <p><strong>Correo Electrónico:</strong> $correo</p>
                        <p><strong>Descripción:</strong> $descripcion</p>";

        $mail->send();
        echo "Solicitud enviada exitosamente.";
    } catch (Exception $e) {
        echo "Hubo un error al enviar la solicitud: {$mail->ErrorInfo}";
    }
}
?>
