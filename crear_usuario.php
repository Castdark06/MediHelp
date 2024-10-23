<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "login_db";

// Conectar a la base de datos
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$message = ""; // Mensaje de error o éxito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario ya existe
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El nombre de usuario ya existe
        $message = "El nombre de usuario ya está en uso.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            $message = "¡Usuario creado correctamente!";
        } else {
            $message = "Error al crear el usuario.";
        }
    }
    $stmt->close();
}

$conn->close();
?>
