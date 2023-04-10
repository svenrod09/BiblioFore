<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // Si no existen credenciales de la sesión
    session_unset();
    session_destroy(); // Cerrar sesión
    header("Location: ./login.php"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    exit;
} else {
    // Si un usuario de tipo = 2 (Editor) es redireccionado a este sitio muestra un mensaje de alerta
    if (isset($_SESSION['permission_alert'])) {
        echo "<script>alert('" . $_SESSION['permission_alert'] . "')</script>"; // Mostrar mensaje de alerta
        unset($_SESSION['permission_alert']); // Eliminar la variable de sesión después de mostrar el mensaje de alerta
    }
}
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
    <link rel="stylesheet" href="./css/adminStyles.css">

    <title>BiblioFore | Inicio</title>

    <!-- Ícono de la pestaña -->
    <link rel="shortcut icon" href="https://erp.unacifor.edu.hn/img/logout.png">
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 theme-bg">
                <div class="sticky-top d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-4 mb-md-0 me-md-auto text-white text-decoration-none">
                        <img src="https://erp.unacifor.edu.hn/img/logout.png" height="40px" width="40px" alt="UNACIFOR">
                        <span class="ms-2 fs-5 fw-bold d-none d-sm-inline">Biblioteca</span>
                    </a>

                    <a href="./adminPage.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-home fs-4 fa-fw activo items-color"></i>
                        <span class="ms-2 d-none d-sm-inline activo fw-bold">Inicio</span></a>

                    <a href="./usuarios/index.php" id="usuarios" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-users fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Usuarios</span></a>

                    <a href="./autores/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-pen-fancy fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Autores</span></a>

                    <a href="./editoriales/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-university fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Editoriales</span></a>

                    <a href="./tipodocumento/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-file fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Tipos</span></a>

                    <a href="./catalogodigital/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-laptop fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Catálogo Digital</span></a>

                    <a href="./catalogofisico/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-book fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Catálogo Físico</span></a>

                    <a href="./referencias/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-quote-right fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Referencias Externas</span></a>

                    <a href="./basesbibliotecas/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-book-reader fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Bibliotecas Externas</span></a>

                    <a href="./logout.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-arrow-left fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Salir</span></a>
                </div>
            </div>

            <!-- Contenido -->
            <div id="content-area" class="col">

                <!-- Título -->
                <div class="container py-5">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <h1 class="text-center fw-bold">¡Bienvenido a la Biblioteca!</h1>
                            <h4 class="text-center">¿Qué desea hacer?</h4>
                        </div>
                    </div>
                </div>

                <!-- Dashboard -->
                <div class="container py-3">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./usuarios/index.php" class="text-decoration-none">
                                <div class="card l-bg-cherry">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Usuarios</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./autores/index.php" class="text-decoration-none">
                                <div class="card l-bg-blue-dark">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-pen-fancy"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Autores</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./editoriales/index.php" class="text-decoration-none">
                                <div class="card l-bg-green-dark">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-university"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Editoriales</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./tipodocumento/index.php" class="text-decoration-none">
                                <div class="card l-bg-orange-dark">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-file"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Tipos de Documento</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./catalogodigital/index.php" class="text-decoration-none">
                                <div class="card l-bg-yellow">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-laptop"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Catálogo Digital</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./catalogofisico/index.php" class="text-decoration-none">
                                <div class="card l-bg-red">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-book"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Catálogo Físico</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./referencias/index.php" class="text-decoration-none">
                                <div class="card l-bg-purple">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-quote-right"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Referencias Externas</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <a href="./basesbibliotecas/index.php" class="text-decoration-none">
                                <div class="card l-bg-blue-light">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-book-reader"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold mb-0">Control de Bibliotecas Externas</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>