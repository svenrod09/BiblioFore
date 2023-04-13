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
$titulo = $_POST['nombreC'];
$descripcion = $_POST['descC'];
$autor = $_POST['autorC'];
$tipo = $_POST['tipoC'];
$editorial = $_POST['editorialC'];
$year = $_POST['yearC'];
$imagen = $_FILES['imgC'];
$tamanoIMG = $imagen['size'];

// Validar el tamaño máximo del archivo
$tamanoMaximoIMG = 10 * 1024 * 1024; // 10 MB

if ($tamanoIMG > $tamanoMaximoIMG) { // Si el tamaño del archivo es mayor que el permitido
    // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
    echo json_encode(array('success' => false, 'message' => '¡Error! Uno de los archivos es demasiado grande.'));
    echo '<script>alert(¡Error! Uno de los archivos es demasiado grande.)</script>';
    exit;
}

// Definir directorio de subida
$path = 'uploads/';

// Obtener los datos del archivo
$img = $_FILES['imgC']['name'];
$tmp = $_FILES['imgC']['tmp_name'];

// Definir fecha para asignar nombre al archivo
date_default_timezone_set('America/Tegucigalpa');
$fecha = date('Y_m_d_his');

// Cambia el nombre del archivo
$final_path = $fecha . $img;

// Define la ruta y el nombre final del archivo
$path = $path . strtolower($final_path);

// Trycatch para la inserción de datos a la BD y la subida de archivos al servidor
try {
    // Mover el archivo al directorio final
    if (move_uploaded_file($tmp, $path)) {
        // Conexión con la BD
        require_once('../config.php');

        // Consulta de inserción PostgreSQL
        $query = "INSERT INTO materialfisico (titulo, descripcion, autorid, tipodocumentoid, editorialid, 
        emisionyear, imagen) VALUES (initcap(:titulo), initcap(:descripcion), :autorid, :tipodocumentoid, 
        :editorialid, :emisionyear, :imagen)";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Asignar valores
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':autorid', $autor);
        $stmt->bindParam(':tipodocumentoid', $tipo);
        $stmt->bindParam(':editorialid', $editorial);
        $stmt->bindParam(':emisionyear', $year);
        $stmt->bindParam(':imagen', $path);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver una respuesta en formato JSON indicando que la inserción ha sido exitosa
        echo json_encode(array('success' => true, 'message' => 'El registro ha sido añadido exitosamente.'));
    } else {
         // Si hubo un error al ejecutar el query elimina los archivos subidos
         unlink($path);
        // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
        echo json_encode(array('success' => false, 'message' => 'Ha ocurrido un error al añadir el registro.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("Error al enviar el archivo: " ' . $e->getMessage() . ');</script>';
}
?>