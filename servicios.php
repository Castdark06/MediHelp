<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios - MediHelp</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos para el formulario */
        .form-container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: #003366;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="tel"],
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0055b3;
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
    </div>
</header>

<div class="form-container">
    <h2>Solicitar Información de Servicios</h2>
    <form action="enviar_servicio.php" method="post">
        <label for="nombre">Nombre del Paciente:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="servicio">Seleccione un Servicio:</label>
        <select id="servicio" name="servicio" required>
            <option value="pruebas">Pruebas</option>
            <option value="consejeria">Consejería</option>
            <option value="dudas_medicamento">Dudas de Medicamento</option>
            <option value="vinculacion">Vinculación</option>
            <option value="perdidas_cita">Pérdidas de Cita</option>
        </select>

        <label for="telefono">Número de Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

        <button type="submit">Enviar Solicitud</button>
    </form>
</div>

</body>
</html>
