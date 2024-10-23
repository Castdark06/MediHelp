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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $inicio_tratamiento = $_POST['inicio_tratamiento'];
    $esquema_arvs = implode(", ", $_POST['esquema_arvs']); // Convertir el array en una cadena
    $meses_medicamento = $_POST['meses_medicamento'];
    $fecha_consulta = $_POST['fecha_consulta'];
    $ultima_cd4 = $_POST['ultima_cd4'];
    $ultima_cv = $_POST['ultima_cv'];

    // Calcular la próxima fecha de consulta
    $proxima_consulta = date('Y-m-d', strtotime("+$meses_medicamento months", strtotime($fecha_consulta)));

    // Manejo de la nueva imagen de perfil si se subió
    $foto_destino = null;
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $foto_nombre = $_FILES['foto_perfil']['name'];
        $foto_tmp = $_FILES['foto_perfil']['tmp_name'];
        $foto_destino = "uploads/" . $foto_nombre;

        if (move_uploaded_file($foto_tmp, $foto_destino)) {
            echo "Archivo subido correctamente.<br>";
        } else {
            echo "Error al mover el archivo.<br>";
        }
    }

    // Actualizar los datos en la base de datos
    if ($foto_destino) {
        $sql = "UPDATE perfil_usuario SET nombre = ?, apellido = ?, inicio_tratamiento = ?, esquema_arvs = ?, ultima_cd4 = ?, ultima_cv = ?, fecha_consulta = ?, proxima_consulta = ?, meses_medicamento = ?, foto_perfil = ? WHERE usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $nombre, $apellido, $inicio_tratamiento, $esquema_arvs, $ultima_cd4, $ultima_cv, $fecha_consulta, $proxima_consulta, $meses_medicamento, $foto_destino, $usuario_id);
    } else {
        $sql = "UPDATE perfil_usuario SET nombre = ?, apellido = ?, inicio_tratamiento = ?, esquema_arvs = ?, ultima_cd4 = ?, ultima_cv = ?, fecha_consulta = ?, proxima_consulta = ?, meses_medicamento = ? WHERE usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $nombre, $apellido, $inicio_tratamiento, $esquema_arvs, $ultima_cd4, $ultima_cv, $fecha_consulta, $proxima_consulta, $meses_medicamento, $usuario_id);
    }

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.<br>";
        header("Location: ver_perfil.php");
        exit();
    } else {
        echo "Error: " . $stmt->error . "<br>";
    }

    $stmt->close();
}
$conn->close();
?>
