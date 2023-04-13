<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // Si no existen credenciales de la sesión
    // Cerrar sesión
    session_unset();
    session_destroy();
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: ../login.php");
    exit;
}

// Conexión con la BD
include '../config.php';

// Obtener los datos del formulario
$usuario = $_POST['usuario'];

// Trycatch para autenticarse en la BD
try {
    // Consulta de selección PostgreSQL
    $query = "SELECT * FROM usuarios WHERE usuario = :usuario";

    // Preparar consulta
    $stmt = $db->prepare($query);

    // Asignar valores
    $stmt->bindParam(':usuario', $usuario);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el nombre de usuario ya existe
    if ($result) { // El usuario existe
        // Devolver una respuesta en formato JSON indicando que la validación ha sido exitosa
        echo json_encode(array('success' => true, 'message' => 'El usuario ya existe.'));
    } else { // El usuario no existe
        // Devolver una respuesta en formato JSON indicando que la validación ha fallado
        echo json_encode(array('success' => false, 'message' => 'El usuario no existe.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("¡Error al intentar iniciar sesión! Contacte al administrador. "'
        . $e->getMessage() . ');</script>';
}
