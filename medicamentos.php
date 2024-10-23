<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos - MediHelp</title>
    <link rel="stylesheet" href="styles.css">
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
                    <li><a href="medicamentos.php">Medicamentos</a></li>
                    <li><a href="contactos.html">Contactos</a></li>
                    <li><a href="alimentacion.html">Alimentación</a></li>
                    <li><a href="informacion.html">Información</a></li>
                </ul>
            </nav>
            <div class="login">
                <a href="#">Entrar</a>
            </div>
        </div>
    </header>

    <section class="medicamentos" id="medicamentos">
    <h2>Medicamentos ARVs</h2>
    <div class="grid-container">
        <?php
        // Conectar a la base de datos
        $conn = new mysqli("localhost", "root", "", "login_db");

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener los datos de los medicamentos
        $sql = "SELECT nombre, abreviatura, ruta_imagen, enlace_detalle FROM medicamentos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar cada medicamento
            while ($row = $result->fetch_assoc()) {
                echo "<div class='medicamento'>";
                echo "<a href='" . $row['enlace_detalle'] . "'>";
                echo "<img src='" . $row['ruta_imagen'] . "' alt='Medicamento " . $row['nombre'] . "'>";
                echo "<h3>" . $row['nombre'] . "</h3>";
                echo "<p>" . $row['abreviatura'] . "</p>";
                echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No se encontraron medicamentos.</p>";
        }

        $conn->close();
        ?>
    </div>
</section>


    <footer>
        <p>MediHelp © 2024</p>
    </footer>
</body>
</html>
