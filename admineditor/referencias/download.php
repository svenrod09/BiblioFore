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

if (isset($_GET['file'])) { // Obtiene la ruta del archivo
    $file_path = $_GET['file']; // Obtiene la ruta del archivo
    if (file_exists($file_path)) { // Si el archivo existe procede a descargarlo
        $file_type = mime_content_type($file_path); // Obtiene tipo del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: '.$file_type);
        header('Content-Disposition: attachment; filename='.basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path);
        exit;
    }
    else { // Si el archivo no exite muestra un error
        echo '<!DOCTYPE html>
        <html lang="en">
        
          <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
            <!-- CSS Personalizado -->
            <link rel="stylesheet" href="../css/adminStyles.css">
            
            <title>BiblioFore | Error 404</title>
        
            <!-- Ícono de la pestaña -->
            <link rel="shortcut icon" href="https://erp.unacifor.edu.hn/img/logout.png">
          </head>
        
          <body>
            <div class="d-flex align-items-center justify-content-center vh-100 theme-bg">
                <h1 class="display-1 fw-bold text-white">404</h1>
                <h3 class="fw-bold text-white"><br><br> Nada por aquí :(</h3>
            </div>
          </body>
        
        </html>';
    }
}
?>