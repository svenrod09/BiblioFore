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
require_once('../config.php');

// Obtener los datos del formulario
$apellido = $_POST['apellido'];
$nombre = $_POST['nombre'];
$paisdenacimiento = $_POST['paisdenacimiento'];

// Trycatch para la inserción de datos
try {
    // Consulta de inserción PostgreSQL
    $query = "INSERT INTO autores (apellido, nombre, paisdenacimiento) VALUES (initcap(:apellido), initcap(:nombre), :paisdenacimiento)";

    // Preparar consulta
    $stmt = $db->prepare($query);

    // Asignar valores
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':paisdenacimiento', $paisdenacimiento);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se ha insertado correctamente
    if ($stmt->rowCount() > 0) {
        // Devolver una respuesta en formato JSON indicando que la inserción ha sido exitosa
        echo json_encode(array('success' => true, 'message' => 'El registro ha sido añadido exitosamente.'));
    } else {
        // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
        echo json_encode(array('success' => false, 'message' => 'Ha ocurrido un error al añadir el registro.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("Error al insertar el registro: " ' . $e->getMessage() . ');</script>';
}
?>