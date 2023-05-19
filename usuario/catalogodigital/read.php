<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['user'])) { // Si no existen credenciales de la sesión
    session_unset();
    session_destroy(); // Cerrar sesión
    header("Location: https://login.unacifor.edu.hn"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    exit;
} else {
    $user = $_SESSION['user']; // Nombre de usuario
}
?>

<?php

// Trycatch para la selección de datos
try {
    // Obtener la columna por la que se ordenarán los datos 
    $file = $_GET['file'];

    // Conexión con la BD
    include '../config.php';

    // Consulta de selección PostgreSQL
    $query = "SELECT md.id AS id, md.titulo, md.descripcion, md.autorid, CONCAT(au.nombre, ' ', au.apellido) 
        AS autor, md.tipodocumentoid, td.nombre AS tipo, md.editorialid, e.nombre AS editorial, md.emisionyear AS year, 
        md.imagen, md.archivo FROM materialdigital AS md INNER JOIN autores au 
        ON md.autorid = au.id INNER JOIN tipodocumento td ON md.tipodocumentoid = td.id 
        INNER JOIN editoriales e ON md.editorialid = e.id WHERE md.id = :file";

    // Preparar consulta
    $stmt = $db->prepare($query);

    // Asignar valores
    $stmt->bindValue(':file', $file);

    // Ejecutar la consulta
    $stmt->execute();

    // Verifica si la consulta devuelve datos
    if ($stmt->rowCount() > 0) { // Si la consulta devuelve datos los muestra en pantalla al usuario
        $row = $stmt->fetch();
        $url_pdf = "https://biblio.unacifor.edu.hn/admin/catalogodigital/" . $row['archivo']; // URL del archivo PDF
        $route_pdf = "../../admin/catalogodigital/" . $row['archivo']; // Ruta del archivo PDF
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- FontAwesome CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

            <!-- CSS Personalizado -->
            <link rel="stylesheet" href="../css/userStyles.css">

            <title>Biblioteca | Catálogo Digital</title>

            <!-- Ícono de la pestaña -->
            <link rel="shortcut icon" href="https://erp.unacifor.edu.hn/img/logout.png">
        </head>

        <body>
            <!-- Navbar -->
            <nav class="navbar fixed-top theme-bg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <!-- Botón para mostrar menú de navbar -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                            <i class="fas fa-bars fs-4"></i>
                        </button>

                        <!-- Botón para mostrar menú de navbar -->
                        <img src="https://erp.unacifor.edu.hn/img/logout.png" class="ms-3" height="40px" width="40px" alt="UNACIFOR">
                        <span class="ms-1 fw-bold fs-4">Biblioteca</span>
                    </a>

                    <!-- Nombre de usuario -->
                    <span class="ml-auto fw-bold text-light mt-1 me-4">
                        <i class="fas fa-user-circle fs-5 me-2"></i><?php echo $user; ?>
                    </span>

                    <!-- Menú de navbar -->
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="../userPage.php">
                                    <i class="fas fa-home fs-5 fa-fw"></i>
                                    <span class="ms-2 fs-5 fw-bold">Inicio</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link activo" href="../catalogodigital/index.php">
                                    <i class="fas fa-laptop fs-5 fa-fw"></i>
                                    <span class="ms-2 fs-5 fw-bold">Catálogo Digital</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../catalogofisico/index.php">
                                    <i class="fas fa-book fs-5 fa-fw"></i>
                                    <span class="ms-2 fs-5 fw-bold">Catálogo Físico</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../referencias/index.php">
                                    <i class="fas fa-quote-right fs-5 fa-fw"></i>
                                    <span class="ms-2 fs-5 fw-bold">Referencias Externas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../basesbibliotecas/index.php">
                                    <i class="fas fa-book-reader fs-5 fa-fw"></i>
                                    <span class="ms-2 fs-5 fw-bold">Bibliotecas Externas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../logout.php">
                                    <i class="fas fa-arrow-left fs-5 fa-fw"></i>
                                    <span class="ms-2 fs-5 fw-bold">Salir</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Contenido -->
            <div class="container wrapper py-5 cnt-shadow">
                <div class="row mt-5">
                    <!-- Encabezado -->
                    <div class="col-12 mt-3 mt-md-0 mb-3">
                        <h1 class="text-center fw-bold">
                            <i id="icon-header" class="fas fa-laptop fa-fw me-2"></i>Catálogo Digital
                        </h1>
                    </div>
                </div>

                <!-- Información del Documento -->
                <div class="row">
                    <div class="col-12 mt-3 mb-3">
                        <div class="container align-items-center">
                            <h5 class="fw-bold text-center">Información del material:</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="container">
                            <div class="list-group">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#verModal" data-title="<?php echo $row['titulo'] ?>" data-aut="<?php echo $row['autor'] ?>" data-desc="<?php echo $row['descripcion'] ?>" data-type="<?php echo $row['tipo'] ?>" data-edit="<?php echo $row['editorial'] ?>" data-year="<?php echo $row['year'] ?>" data-image="../../admin/catalogodigital/<?php echo $row['imagen'] ?>" class="list-group-item open-modal">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="aspect-ratio ratio-1x1 justify-content-center align-items-center">
                                                <img src="../../admin/catalogodigital/<?php echo $row['imagen'] ?>" class="img-fluid img-square img-thumbnail">
                                            </div>
                                        </div>
                                        <div class="col-9 mt-2">
                                            <div class="container">
                                                <h5 class="fw-bold"><?php echo $row['titulo'] ?></h5>
                                                <p><span class="fw-bold">Autor: </span><?php echo $row['autor'] ?></p>
                                                <p><span class="fw-bold">Descripción: </span><?php echo $row['descripcion'] ?></p>
                                                <p><span class="fw-bold">Categoría: </span><?php echo $row['tipo'] ?></p>
                                                <p><span class="fw-bold">Editorial: </span><?php echo $row['editorial'] ?></p>
                                                <p><span class="fw-bold">Año de emisión: </span><?php echo $row['year'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Opciones -->
                    <div class="col-12 col-md-4 mt-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="container d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-column">
                                        <a href="<?php echo $route_pdf; ?>" target="_blank" class="btn btn-primary mt-3 mb-3"><i class="fas fa-eye fs-5 me-2"></i>Ver en el navegador</a>
                                        <a href="./download.php?file=<?php echo $route_pdf; ?>" class="btn btn-success"><i class="fas fa-download fs-5 me-2"></i>Descargar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visor de PDF -->
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="embed-responsive">
                                <iframe class="embed-responsive-item" src="./pdfjs/web/viewer.html?file=<?php echo $url_pdf; ?>" width="100%" height="600px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para ver los datos del Catálogo -->
                <div class="modal fade" id="verModal" tabindex="-1" role="dialog" aria-labelledby="verModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="verModal"><i class="fas fa-laptop fa-fw me-2"></i>Información del material:</h5>
                                <i id="close-modal" data-dismiss="modal" class="fas fa-times fw-bold fa-fw fs-5" style="cursor: pointer;"></i>
                            </div>
                            <div class="modal-body">
                                <h5 id="titulo" class="fw-bold text-center"></h5>
                                <div class="d-flex justify-content-center align-items-center mt-3 mb-3">
                                    <img id="imagen" src="" class="img-fluid img-square img-thumbnail">
                                </div>
                                <div class="ms-2">
                                    <p><span class="fw-bold">Autor: </span><span id="autor"></span></p>
                                    <p><span class="fw-bold">Descripción: </span><span id="descripcion"></span></p>
                                    <p><span class="fw-bold">Categoría: </span><span id="tipo"></span></p>
                                    <p><span class="fw-bold">Editorial: </span><span id="editorial"></span></p>
                                    <p><span class="fw-bold">Año de emisión: </span><span id="year"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- Footer -->
            <footer class="text-center text-white theme-bg">
                <div class="container pt-4">
                    <!-- Logo y lema -->
                    <section class="mb-1">
                        <img src="https://erp.unacifor.edu.hn/img/logout.png" width="80px" height="80px" alt="UNACIFOR">
                        <p class="mt-2 text-light fw-bold lema">In arbore vita hominum est</p>
                    </section>

                    <!-- Redes sociales -->
                    <section class="mb-4">

                        <!-- Facebook link -->
                        <a class="btn btn-link btn-floating btn-lg text-light m-1" href="https://www.facebook.com/UNACIFORHN" target="_blank" role="button" data-mdb-ripple-color="light"><i class="fab fa-facebook-f footer-icon"></i></a>

                        <!-- Twitter link -->
                        <a class="btn btn-link btn-floating btn-lg text-light m-1" href="https://twitter.com/unaciforhn" target="_blank" role="button" data-mdb-ripple-color="light"><i class="fab fa-twitter footer-icon"></i></a>

                        <!-- Youtube link -->
                        <a class="btn btn-link btn-floating btn-lg text-light m-1" href="https://www.youtube.com/channel/UCcoa_0FU0eLKJBR7nudKo_Q" target="_blank" role="button" data-mdb-ripple-color="light"><i class="fab fa-youtube footer-icon"></i></a>

                        <!-- Instagram link -->
                        <a class="btn btn-link btn-floating btn-lg text-light m-1" href="https://www.instagram.com/unaciforhn/" target="_blank" role="button" data-mdb-ripple-color="light"><i class="fab fa-instagram footer-icon"></i></a>

                    </section>
                </div>

                <!-- Copyright -->
                <div class="text-center text-light p-3" style="background-color: rgba(0, 0, 0, 0.4);">
                    Copyright © 2023 | Diseñado por UNACIFOR
                </div>
            </footer>

            <!-- Bootstrap Bundle -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

            <!-- Funcionalidad -->
            <script>
                $(document).ready(function() {
                    // Al hacer click en un elemento de la lista con la clase .open-modal abrir modal y asignar valores
                    $(document).on('click', '.open-modal', function() {
                        // Obtiene los valores del elemento de la lista mediante el atributo data-
                        var title = $(this).data('title'); // Título 
                        var autor = $(this).data('aut'); // Autor
                        var desc = $(this).data('desc'); // Descripción
                        var type = $(this).data('type'); // Tipo
                        var edit = $(this).data('edit'); // Editorial
                        var year = $(this).data('year'); // Año de Emisión
                        var image = $(this).data('image'); // Imagen
                        // Muestra los valores en el modal
                        $('#titulo').text(title); // Título 
                        $('#autor').text(autor); // Autor
                        $('#descripcion').text(desc); // Descripción
                        $('#tipo').text(type); // Tipo
                        $('#editorial').text(edit); // Editorial
                        $('#year').text(year); // Año de Emisión
                        $("#imagen").attr("src", image); // Imagen
                    });

                    // Al hacer click en el botón de x del modal, cerrar modal
                    $(document).on('click', '#close-modal', function() {
                        $('#verModal').modal('hide'); // Cerrar modal
                    });
                });
            </script>
        </body>

        </html>
<?php
    } else {
        noData(); // Mostrar mensaje indicando que no hay datos
    }
} catch (PDOException $e) {
    noData(); // Mostrar mensaje indicando que no hay datos
    echo '<script>console.log("¡Error! Causa: "' . $e->getMessage() . ');</script>'; // Imprime el error en la consola
}

// Función para mostrar mensaje en pantalla indicando que no hay datos
function noData()
{
    // Mostrar mensaje en pantalla indicando que no hay datos
    echo '<!DOCTYPE html>
    <html lang="en">
    
      <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- FontAwesome CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- CSS Personalizado -->
        <link rel="stylesheet" href="../css/userStyles.css">
        
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
?>