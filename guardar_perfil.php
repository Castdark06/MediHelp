<?php
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
    $esquema_arvs = $_POST['esquema_arvs']; // Array de medicamentos seleccionados
    $meses_medicamento = $_POST['meses_medicamento'];
    $fecha_consulta = $_POST['fecha_consulta'];
    $ultima_cd4 = $_POST['ultima_cd4'];
    $ultima_cv = $_POST['ultima_cv'];

    // Calcular la próxima fecha de consulta
    $proxima_consulta = date('Y-m-d', strtotime("+$meses_medicamento months", strtotime($fecha_consulta)));

    // Manejo de subida de imagen
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
    } else {
        echo "Error al subir el archivo. Código de error: " . $_FILES['foto_perfil']['error'] . "<br>";
    }

    // Consultar las dosis y frecuencias de los medicamentos seleccionados
    $medicamentos = implode("', '", $esquema_arvs); // Convertir array en cadena para la consulta
    $sql_medicamentos = "SELECT nombre, dosis, frecuencia FROM arvs WHERE nombre IN ('$medicamentos')";
    $result_meds = $conn->query($sql_medicamentos);

    echo "<h2>Información sobre los medicamentos seleccionados</h2>";
    if ($result_meds->num_rows > 0) {
        while ($row = $result_meds->fetch_assoc()) {
            echo "Medicamento: " . $row['nombre'] . "<br>";
            echo "Dosis: " . $row['dosis'] . "<br>";
            echo "Cada cuántas horas: " . $row['frecuencia'] . " horas<br><br>";
        }
    } else {
        echo "No se encontraron datos para los medicamentos seleccionados.";
    }

    // Guardar el perfil del usuario en la base de datos
    $esquema_arvs_str = implode(", ", $esquema_arvs); // Convertir el array en una cadena
    $sql = "INSERT INTO perfil_usuario (usuario_id, nombre, apellido, inicio_tratamiento, esquema_arvs, ultima_cd4, ultima_cv, fecha_consulta, proxima_consulta, meses_medicamento, foto_perfil) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $nombre, $apellido, $inicio_tratamiento, $esquema_arvs_str, $ultima_cd4, $ultima_cv, $fecha_consulta, $proxima_consulta, $meses_medicamento, $foto_destino);

    if ($stmt->execute()) {
        echo "Datos guardados correctamente.<br>";
        header("Location: ver_perfil.php");
        exit();
    } else {
        echo "Error: " . $stmt->error . "<br>";
    }

    $stmt->close();
}
$conn->close();
?>
