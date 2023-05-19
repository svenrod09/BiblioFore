<?php
// Verificar credenciales de la sesión
if (!empty($_POST)) {
    if (isset($_POST['user'])) { // Si se han enviado las credenciales
        $usr = $_POST['user']; // Nombre de usuario
        // Establecer credenciales de sesión
        session_start();
        $_SESSION['user'] = $usr; // Usuario
        header("Location: https://biblio.unacifor.edu.hn/usuario/userPage.php"); // Redirigir a la página de inicio      
    } else { // Si no existen credenciales de la sesión
        session_start();
        session_unset();
        session_destroy(); // Cerrar sesión
        header("Location: https://login.unacifor.edu.hn"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
        exit;
    }
}
?>