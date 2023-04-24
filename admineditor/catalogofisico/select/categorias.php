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

// Trycatch para la selección de datos de la BD
try {
    // Conexión con la BD
    include '../config.php';

    // Consulta de selección PostgreSQL
    $query = "SELECT * FROM tipodocumento WHERE disponible = true";

    // Preparar consulta
    $stmt = $db->prepare($query);

    // Ejecutar la consulta
    $stmt->execute();

    // Llena el select con los datos obtenidos
    while ($row = $stmt->fetch()) {
        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("¡Error! No se pudieron obtener los datos: " ' . $e->getMessage() . ');</script>';
}
?>