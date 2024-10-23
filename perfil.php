<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - MediHelp</title>
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

<div class="profile-container">
    <h2>Perfil del Usuario</h2>
    <form action="guardar_perfil.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="inicio_tratamiento">Inicio de Tratamiento:</label>
        <input type="date" id="inicio_tratamiento" name="inicio_tratamiento" required><br><br>

        <label>Esquema Actual de ARVs:</label><br>
        <input type="checkbox" name="esquema_arvs[]" value="TDF+FTC"> TDF+FTC<br>
        <input type="checkbox" name="esquema_arvs[]" value="RAL"> RAL<br>
        <input type="checkbox" name="esquema_arvs[]" value="TAF+FTC+BIC"> TAF+FTC+BIC<br>
        <input type="checkbox" name="esquema_arvs[]" value="TAF+FTC+DTG"> TAF+FTC+DTG<br>
        <input type="checkbox" name="esquema_arvs[]" value="ABC 3TC"> ABC 3TC<br>
        <input type="checkbox" name="esquema_arvs[]" value="DRV RTV"> DRV RTV<br>
        <input type="checkbox" name="esquema_arvs[]" value="MVR"> MVR<br>
        <input type="checkbox" name="esquema_arvs[]" value="LPV+RTV"> LPV+RTV<br>
        <input type="checkbox" name="esquema_arvs[]" value="DRV+COBI"> DRV+COBI<br>
        <input type="checkbox" name="esquema_arvs[]" value="TDF"> TDF<br>
        <input type="checkbox" name="esquema_arvs[]" value="TAF+FTC+EVG+COBI"> TAF+FTC+EVG+COBI<br>
        <input type="checkbox" name="esquema_arvs[]" value="AZT 3TC"> AZT 3TC<br>
        <input type="checkbox" name="esquema_arvs[]" value="EFV"> EFV<br><br>

        <label for="meses_medicamento">Número de meses de medicamento:</label>
        <input type="number" id="meses_medicamento" name="meses_medicamento" required><br><br>

        <label for="fecha_consulta">Fecha de Consulta:</label>
        <input type="date" id="fecha_consulta" name="fecha_consulta" required><br><br>

        <label for="proxima_consulta">Próxima Fecha de Consulta:</label>
        <input type="date" id="proxima_consulta" name="proxima_consulta" readonly><br><br>

        <label for="ultima_cd4">Última CD4:</label>
        <input type="text" id="ultima_cd4" name="ultima_cd4" required><br><br>

        <label for="ultima_cv">Última Carga Viral (CV):</label>
        <input type="text" id="ultima_cv" name="ultima_cv" required><br><br>

        <label for="foto_perfil">Subir foto de perfil:</label>
        <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" required><br><br>

        <button type="submit">Guardar</button>
    </form>
</div>

</body>
</html>
