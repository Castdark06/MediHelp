<?php
session_start(); // Iniciar la sesión

$servername = "localhost";
$dbusername = "root"; // Usuario de MySQL
$dbpassword = ""; // Contraseña de MySQL
$dbname = "login_db";

// Crear conexión
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$message = ""; // Mensaje de error o éxito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar usuario
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();

        // Comparación directa sin encriptación (esto es inseguro, deberías usar password_hash y password_verify)
        if ($password === $stored_password) {
            // Login exitoso, guardar el ID del usuario en la sesión
            $_SESSION['usuario_id'] = $user_id;

            // Redirigir al perfil del usuario
            header("Location: ver_perfil.php");
            exit();
        } else {
            $message = "Contraseña incorrecta.";
        }
        
    } else {
        $message = "Usuario no encontrado.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - MediHelp</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener este archivo con estilos globales -->
    <style>
        /* Estilos específicos para el login */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        .login-container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0055b3;
        }

        .login-container p {
            color: #ff0000; /* Color de error */
        }
        
        /* Mensaje de éxito */
        .success {
            color: #28a745;
        }
    </style>
</head>
<body>

<header>
    <div class="navbar">
        <div class="logo">
            <h1>MediHelp</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Acerca de</a></li>
                <li><a href="medicamentos.html">Medicamentos</a></li>
                <li><a href="contactos.html">Contactos</a></li>
                <li><a href="alimentacion.html">Alimentación</a></li>
                <li><a href="informacion.html">Información</a></li>
            </ul>
        </nav>
        <div class="login">
            <a href="login.php">Entrar</a>
        </div>
    </div>
</header>

<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($message)): ?>
        <p class="<?php echo ($message === "¡Login exitoso!") ? 'success' : 'error'; ?>"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
