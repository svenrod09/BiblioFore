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
$archivo = $_FILES['fileC'];
$tamanoIMG = $imagen['size'];
$tamanoArchivo = $archivo['size'];

// Validar el tamaño máximo del archivo
$tamanoMaximo = 500 * 1024 * 1024; // 500 MB
$tamanoMaximoIMG = 10 * 1024 * 1024; // 10 MB

if ($tamanoArchivo > $tamanoMaximo || $tamanoIMG > $tamanoMaximoIMG) { // Si el tamaño del archivo es mayor que el permitido
    // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
    echo json_encode(array('success' => false, 'message' => '¡Error! Uno de los archivos es demasiado grande.'));
    echo '<script>alert(¡Error! Uno de los archivos es demasiado grande.)</script>';
    exit;
}

// Definir directorio de subida
$path = 'uploads/';
$path_pdf = 'uploads/';

// Obtener los datos del archivo
$img = $_FILES['imgC']['name'];
$tmp = $_FILES['imgC']['tmp_name'];
$pdf = $_FILES['fileC']['name'];
$tmp_pdf = $_FILES['fileC']['tmp_name'];

// Definir fecha para asignar nombre al archivo
date_default_timezone_set('America/Tegucigalpa');
$fecha = date('Y_m_d_his');

// Cambia el nombre del archivo
$final_path = $fecha . $img;
$final_path_pdf = $fecha . $pdf;

// Define la ruta y el nombre final del archivo
$path = $path . strtolower($final_path);
$path_pdf = $path_pdf . strtolower($final_path_pdf);

// Trycatch para la inserción de datos a la BD y la subida de archivos al servidor
try {
    // Mover el archivo al directorio final
    if (move_uploaded_file($tmp, $path) && move_uploaded_file($tmp_pdf, $path_pdf)) {
        // Conexión con la BD
        require_once('../config.php');

        // Consulta de inserción PostgreSQL
        $query = "INSERT INTO materialdigital (titulo, descripcion, autorid, tipodocumentoid, editorialid, 
        emisionyear, imagen, archivo) VALUES (initcap(:titulo), initcap(:descripcion), :autorid, :tipodocumentoid, 
        :editorialid, :emisionyear, :imagen, :archivo)";

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
        $stmt->bindParam(':archivo', $path_pdf);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver una respuesta en formato JSON indicando que la inserción ha sido exitosa
        echo json_encode(array('success' => true, 'message' => 'El registro ha sido añadido exitosamente.'));
    } else {
         // Si hubo un error al ejecutar el query elimina los archivos subidos
         unlink($path);
         unlink($path_pdf);
        // Devolver una respuesta en formato JSON indicando que la inserción ha fallado
        echo json_encode(array('success' => false, 'message' => 'Ha ocurrido un error al añadir el registro.'));
    }
} catch (PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("Error al enviar el archivo: " ' . $e->getMessage() . ');</script>';
}
?>