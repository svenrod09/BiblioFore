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

    <title>Biblioteca | Material Digital</title>

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
                        <a class="nav-link activo" href="../materialdigital/index.php">
                            <i class="fas fa-laptop fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Material Digital</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../materialfisico/index.php">
                            <i class="fas fa-book fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Material Físico</span>
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
</body>

</html>