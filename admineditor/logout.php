<?php
session_start(); // Verificar credenciales de la sesión
session_unset(); // Eliminar las credenciales de la sesión
session_destroy(); // Cerrar sesión
header("Location: ./login.php"); // Redirigir al usuario a la página de inicio de sesión (login)
exit;
?>