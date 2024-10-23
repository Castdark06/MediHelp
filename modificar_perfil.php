<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Si no hay un usuario autenticado, redirigir al inicio de sesión
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id']; // Obtener el ID del usuario autenticado

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "login_db";

// Crear conexión
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los datos del perfil del usuario autenticado
$sql = "SELECT nombre, apellido, inicio_tratamiento, esquema_arvs, ultima_cd4, ultima_cv, fecha_consulta, proxima_consulta, meses_medicamento, foto_perfil FROM perfil_usuario WHERE usuario_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id); // Pasar el ID del usuario autenticado
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Si no hay datos de perfil, redirigir al formulario para ingresar datos
    header("Location: perfil.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Perfil - MediHelp</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .profile-container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-container h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        .profile-container input[type="text"],
        .profile-container input[type="date"],
        .profile-container select,
        .profile-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .profile-container button {
            width: 100%;
            padding: 10px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-container button:hover {
            background-color: #0055b3;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Modificar Perfil</h2>
    <form action="guardar_cambios_perfil.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($row['apellido']); ?>" required><br><br>

        <label for="inicio_tratamiento">Inicio de Tratamiento:</label>
        <input type="date" id="inicio_tratamiento" name="inicio_tratamiento" value="<?php echo htmlspecialchars($row['inicio_tratamiento']); ?>" required><br><br>

        <label>Esquema Actual de ARVs:</label><br>
        <?php
        $esquema_arvs = explode(", ", $row['esquema_arvs']); // Convertir cadena en array
        $medicamentos = ['TDF+FTC', 'RAL', 'TAF+FTC+BIC', 'TAF+FTC+DTG', 'ABC 3TC', 'DRV RTV', 'MVR', 'LPV+RTV', 'DRV+COBI', 'TDF', 'TAF+FTC+EVG+COBI', 'AZT 3TC', 'EFV'];
        foreach ($medicamentos as $medicamento) {
            $checked = in_array($medicamento, $esquema_arvs) ? 'checked' : '';
            echo "<input type='checkbox' name='esquema_arvs[]' value='$medicamento' $checked> $medicamento<br>";
        }
        ?><br>

        <label for="meses_medicamento">Número de meses de medicamento:</label>
        <input type="number" id="meses_medicamento" name="meses_medicamento" value="<?php echo htmlspecialchars($row['meses_medicamento']); ?>" required><br><br>

        <label for="fecha_consulta">Fecha de Consulta:</label>
        <input type="date" id="fecha_consulta" name="fecha_consulta" value="<?php echo htmlspecialchars($row['fecha_consulta']); ?>" required><br><br>

        <label for="proxima_consulta">Próxima Fecha de Consulta:</label>
        <input type="date" id="proxima_consulta" name="proxima_consulta" value="<?php echo htmlspecialchars($row['proxima_consulta']); ?>" readonly><br><br>

        <label for="ultima_cd4">Última CD4:</label>
        <input type="text" id="ultima_cd4" name="ultima_cd4" value="<?php echo htmlspecialchars($row['ultima_cd4']); ?>" required><br><br>

        <label for="ultima_cv">Última Carga Viral (CV):</label>
        <input type="text" id="ultima_cv" name="ultima_cv" value="<?php echo htmlspecialchars($row['ultima_cv']); ?>" required><br><br>

        <label for="foto_perfil">Subir nueva foto de perfil (opcional):</label>
        <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*"><br><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
