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
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$autor = $_POST['autor'];
$tipo = $_POST['tipo'];
$editorial = $_POST['editorial'];
$year = $_POST['year'];

// Trycatch para la actualización de datos
try {
    // Consulta de actualización PostgreSQL
    $query = "UPDATE materialdigital SET titulo = initcap(:titulo), descripcion = initcap(:descripcion), 
    autorid = :autorid, tipodocumentoid = :tipodocumentoid, editorialid = :editorialid, 
    emisionyear = :emisionyear WHERE id = :id";

    // Preparar consulta
    $stmt = $db->prepare($query);

    // Asignar valores
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':autorid', $autor);
    $stmt->bindParam(':tipodocumentoid', $tipo);
    $stmt->bindParam(':editorialid', $editorial);
    $stmt->bindParam(':emisionyear', $year);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se ha actualizado correctamente
    if ($stmt->rowCount() > 0) {
        // Devolver una respuesta en formato JSON indicando que la actualización ha sido exitosa
        echo json_encode(array('success' => true, 'message' => 'El registro ha sido actualizado exitosamente.'));
    } else {
        // Devolver una respuesta en formato JSON indicando que la actualización ha fallado
        echo json_encode(array('success' => false, 'message' => 'Ha ocurrido un error al actualizar el registro.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("Error al actualizar el registro: " ' . $e->getMessage() . ');</script>';
}
?>