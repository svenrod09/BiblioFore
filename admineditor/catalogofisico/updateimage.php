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
$imagen = $_FILES['imgE'];
$imagenActual = $_POST['imagenActual'];
$tamanoArchivo = $imagen['size'];

// Validar el tamaño máximo del archivo
$tamanoMaximo = 10 * 1024 * 1024; // 10 MB

if ($tamanoArchivo > $tamanoMaximo) { // Si el tamaño del archivo es mayor que el permitido
    // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
    echo json_encode(array('success' => false, 'message' => 'El archivo es demasiado grande. El tamaño máximo permitido es de 10 MB.'));
    echo '<script>alert(El archivo es demasiado grande. El tamaño máximo permitido es de 10 MB.)</script>';
    exit;
}

// Definir directorio de subida
$path = 'uploads/';

// Obtener los datos del archivo
$img = $_FILES['imgE']['name'];
$tmp = $_FILES['imgE']['tmp_name'];

// Definir fecha para asignar nombre al archivo
date_default_timezone_set('America/Tegucigalpa');
$fecha = date('Y_m_d_his');

// Cambia el nombre del archivo
$final_path = $fecha . $img;

// Define la ruta y el nombre final del archivo
$path = $path . strtolower($final_path);

// Trycatch para la actualización de datos de la BD y la subida de archivos al servidor
try {
    // Mover el archivo al directorio final
    if (move_uploaded_file($tmp, $path) && !!$imagenActual) {
        // Conexión con la BD
        require_once('../config.php');

        // Consulta de actualización PostgreSQL
        $query = "UPDATE materialfisico SET imagen = :imagen WHERE id = :id";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Asignar valores
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':imagen', $path);

        // Ejecutar la consulta
        $stmt->execute();

         // Devolver una respuesta en formato JSON indicando que la actualización ha sido exitosa
         echo json_encode(array('success' => true, 'message' => 'El registro ha sido actualizado exitosamente.'));

         // Eliminar archivo anterior
         unlink($imagenActual);
    } else {
        // Si hubo un error al ejecutar el query elimina los archivos subidos
        unlink($path);
        // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
        echo json_encode(array('success' => false, 'message' => 'Ha ocurrido un error al actualizar el registro.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>alert("Error al enviar el archivo: " ' . $e->getMessage() . ')</script>';
}
?>