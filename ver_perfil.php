<?php
session_start(); // Iniciar la sesión para acceder al ID del usuario

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

// Consulta para obtener los datos del usuario autenticado
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
    <title>Ver Perfil - MediHelp</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .view-profile-container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .view-profile-container h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        .view-profile-container p {
            font-size: 16px;
            color: #333;
        }

        .view-profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
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
                <li><a href="ver_perfil.php">Perfil</a></li>
            </ul>
        </nav>
        <div class="login">
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</header>

<div class="view-profile-container">
    <h2>Perfil del Usuario</h2>
    <?php if (!empty($row)): ?>
        <?php if (!empty($row['foto_perfil'])): ?>
            <img src="<?php echo htmlspecialchars($row['foto_perfil']); ?>" alt="Foto de perfil">
        <?php else: ?>
            <p><em>No se ha subido una foto de perfil</em></p>
        <?php endif; ?>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($row['nombre']); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($row['apellido']); ?></p>
        <p><strong>Inicio de Tratamiento:</strong> <?php echo htmlspecialchars($row['inicio_tratamiento']); ?></p>
        <p><strong>Última CD4:</strong> <?php echo htmlspecialchars($row['ultima_cd4']); ?></p>
        <p><strong>Última Carga Viral (CV):</strong> <?php echo htmlspecialchars($row['ultima_cv']); ?></p>
        <p><strong>Fecha de Consulta:</strong> <?php echo htmlspecialchars($row['fecha_consulta']); ?></p>
        <p><strong>Próxima Consulta:</strong> <?php echo htmlspecialchars($row['proxima_consulta']); ?></p>
        <p><strong>Número de Meses de Medicamento:</strong> <?php echo htmlspecialchars($row['meses_medicamento']); ?></p>

        <!-- Mostrar los medicamentos seleccionados y sus dosis y frecuencia -->
        <h3>Esquema Actual de ARVs</h3>
        <?php
        // Volver a conectar para consultar los medicamentos
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consultar la dosis y frecuencia de los medicamentos seleccionados
        $esquema_arvs = explode(", ", $row['esquema_arvs']); // Convertir cadena en array
        $medicamentos = implode("', '", $esquema_arvs); // Convertir array en cadena para la consulta
        $sql_medicamentos = "SELECT nombre, dosis, frecuencia FROM arvs WHERE nombre IN ('$medicamentos')";
        $result_meds = $conn->query($sql_medicamentos);

        if ($result_meds->num_rows > 0) {
            while ($med_row = $result_meds->fetch_assoc()) {
                echo "<p>Medicamento: " . htmlspecialchars($med_row['nombre']) . "<br>";
                echo "Dosis: " . htmlspecialchars($med_row['dosis']) . "<br>";
                echo "Frecuencia: Cada " . htmlspecialchars($med_row['frecuencia']) . " horas</p>";
            }
        } else {
            echo "No se encontraron datos de medicamentos.";
        }

        $conn->close();
        ?>
    <?php endif; ?>
    <p><a href="logout.php">Cerrar sesión</a></p>
    <p><a href="modificar_perfil.php">Modificar</a></p>
</div>

</body>
</html>
