<?php
session_start();
session_destroy(); // Destruir la sesión actual
header("Location: login.php"); // Redirigir al inicio de sesión
exit();
