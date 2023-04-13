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

// Obtener los datos del formulario
$id = $_POST['id'];
$imagen = $_POST['imagen'];

// Trycatch para la eliminación de datos
try {
    // Verifica que el formulario no envíe valores vacíos
    if (!!$id && !!$imagen) {
        // Conexión con la BD
        require_once('../config.php');

        // Consulta de eliminación PostgreSQL
        $query = "DELETE FROM basesbibliotecas WHERE id = :id";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Asignar valores
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta
        $stmt->execute();

        // Eliminar los archivos 
        unlink($imagen);

        // Devolver una respuesta en formato JSON indicando que la eliminación ha sido exitosa
        echo json_encode(array('success' => true, 'message' => 'El registro ha sido eliminado exitosamente.'));
    } else {
        // Devolver una respuesta en formato JSON indicando que la eliminación ha fallado
        echo json_encode(array('success' => false, 'message' => 'Ha ocurrido un error al eliminar el registro.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("Error al eliminar el registro: " ' . $e->getMessage() . ');</script>';
}
?>
