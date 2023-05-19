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
    <link rel="stylesheet" href="./css/userStyles.css">

    <title>Biblioteca | Inicio</title>

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
                        <a class="nav-link activo" href="./userPage.php">
                            <i class="fas fa-home fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-laptop fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Catálogo Digital</span>
                        </a>
                        <div id="subMenuDigital" class="dropdown-menu theme-bg border-0" aria-labelledby="navbarDropdown">

                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Catálogo Físico</span>
                        </a>
                        <div id="subMenuFisico" class="dropdown-menu theme-bg border-0" aria-labelledby="navbarDropdown1">

                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./referencias/index.php">
                            <i class="fas fa-quote-right fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Referencias Externas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./basesbibliotecas/index.php">
                            <i class="fas fa-book-reader fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Bibliotecas Externas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="./help/index.php">
                            <i class="fas fa-question-circle fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Ayuda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">
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
        <!-- Encabezado -->
        <div class="container mt-5 py-3">
            <div class="row justify-content-center align-items-center">
                <div class="col-12">
                    <h1 class="text-center fw-bold mb-3">
                        <i id="icon-header" class="fas fa-home fa-fw me-2"></i>Inicio
                    </h1>
                    <h2 class="text-center fw-bold">¡Bienvenido a la Biblioteca! &#128075</h2>
                    <h4 class="text-center">¿Qué deseas ver? &#129300</h4>
                </div>
            </div>
        </div>

        <!-- Dashboard -->
        <div class="container py-3">
            <div class="row justify-content-center align-items-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="./catalogodigital/index.php" class="text-decoration-none">
                        <div class="card l-bg-yellow">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-laptop"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title fw-bold mb-0">Catálogo Digital</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="./catalogofisico/index.php" class="text-decoration-none">
                        <div class="card l-bg-blue-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-book"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title fw-bold mb-0">Catálogo Físico</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="./referencias/index.php" class="text-decoration-none">
                        <div class="card l-bg-red">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-quote-right"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title fw-bold mb-0">Referencias Externas</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="./basesbibliotecas/index.php" class="text-decoration-none">
                        <div class="card l-bg-green-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-book-reader"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title fw-bold mb-0">Bibliotecas Externas</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Carousel -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://unacifor.edu.hn/wp-content/uploads/2022/05/WhatsApp-Image-2022-04-20-at-2.36.02-PM-min.jpeg" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="https://unacifor.edu.hn/wp-content/uploads/2022/05/WhatsApp-Image-2022-04-20-at-2.36.03-PM.jpeg" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="https://unacifor.edu.hn/wp-content/uploads/2022/05/IMG_3426-1-min-e1652393938929.jpg" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="https://unacifor.edu.hn/wp-content/uploads/2022/05/WhatsApp-Image-2022-04-20-at-2.36.04-PM.jpeg" class="d-block w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
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
            // Llenar los submenú del navbar al dar click
            // Catálogo Digital
            $('#navbarDropdown').click(function(){
                $('#subMenuDigital').load('./submenu/submenu_digital.php');
            });

            // Catálogo Físico
            $('#navbarDropdown1').click(function(){
                $('#subMenuFisico').load('./submenu/submenu_fisico.php');
            });
        });
    </script>
</body>

</html>