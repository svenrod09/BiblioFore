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

    <title>Biblioteca | Material Físico</title>

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
                        <a class="nav-link" href="../materialdigital/index.php">
                            <i class="fas fa-laptop fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Material Digital</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link activo" href="../materialfisico/index.php">
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

    <!-- Contenido -->
    <div class="container wrapper py-5 cnt-shadow">
        <div class="row mt-5">
            <!-- Encabezado -->
            <div class="col-12 mb-3">
                <h1 class="text-center fw-bold">
                    <i id="icon-header" class="fas fa-book fa-fw me-2"></i>Material Físico
                </h1>
            </div>
        </div>

        <div class="row">
            <!-- Barra de búsqueda -->
            <div class="col-12 col-md-8 mb-3">
                <div class="input-group">
                    <input id="search" type="text" class="form-control" placeholder="Buscar">
                    <div class="input-group-append">
                        <button id="searchBtn" class="btn btn-outline-theme" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Datos -->
            <div class="col-12 col-md-8 order-2 order-md-1 mb-3">
                <div class="container">
                    <div id="contenido" class="row justify-content-center">

                    </div>
                </div>
            </div>

            <!-- Panel de ordenar -->
            <div class="col-12 col-md-4 order-1 order-md-2 mb-3">
                <h4 class="fw-bold">Ordenar por:</h4>
                <div class="list-group">
                    <a href="#" id="order" class="list-group-item active-list fw-bold">
                        <i id="ordericon" class="fas fa-arrow-up"></i>
                        <span class="ms-2">Título</span>
                    </a>
                    <a href="./index_autor.php" class="list-group-item fw-bold">
                        <span>Autor</span>
                    </a>
                    <a href="./index_descripcion.php" class="list-group-item fw-bold">
                        <span>Descripción</span>
                    </a>
                    <a href="./index_tipo.php" class="list-group-item fw-bold">
                        <span>Tipo</span>
                    </a>
                    <a href="./index_editorial.php" class="list-group-item fw-bold">
                        <span>Editorial</span>
                    </a>
                    <a href="./index_year.php" class="list-group-item fw-bold">
                        <span>Año de Emisión</span>
                    </a>
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
            var ascendente = true; // Ordenamiento ascendente por defecto (A-Z)

            ordenarASC(); // Ordenar los datos de forma ascendente

            // Obtener el id del botón e ícono de ordenamiento
            const ordenarButton = document.getElementById('order');
            const ordenarIcon = document.getElementById('ordericon');

            // Cambia el ordenamiento de los datos al dar click en el panel lateral de ordenar por
            ordenarButton.addEventListener('click', function() {
                if (ascendente === true) {
                    ascendente = false; // Ordenamiento descendente (Z-A)
                    ordenarIcon.classList.remove('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.add('fa-arrow-down'); // Cambia el ícono de ordenamiento

                    // Petición AJAX para ordenar los datos
                    var columna = "titulo"; // Columna de la BD por la que se desea ordenar los datos
                    var contenidoDiv = document.getElementById('contenido'); // Div que aloja el contenido 
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) { // La petición se ejecuta correctamente
                            contenidoDiv.outerHTML = this.responseText; // Cambia el contenido del div con el resultado de la consulta
                        }
                    };
                    xhttp.open("GET", "./desc.php?column=" + encodeURIComponent(columna), true); // Archivo que contiene la consulta 
                    xhttp.send(); // Realizar la petición
                } else {
                    ascendente = true; // Ordenamiento ascendente (A-Z)
                    ordenarASC(); // Ordenar los datos de forma ascendente
                }
            });

            // Al presionar el botón de buscar se realiza la búsqueda 
            $('#searchBtn').click(function() {
                busqueda();
            });

            // Función para ordenar los datos de forma ascendente (A-Z)
            function ordenarASC() {
                // Petición AJAX para ordenar los datos
                var columna = "titulo"; // Columna de la BD por la que se desea ordenar los datos
                var contenidoDiv = document.getElementById('contenido'); // Div que aloja el contenido 
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) { // La petición se ejecuta correctamente
                        contenidoDiv.outerHTML = this.responseText; // Cambia el contenido del div con el resultado de la consulta
                    }
                };
                xhttp.open("GET", "./asc.php?column=" + encodeURIComponent(columna), true); // Archivo que contiene la consulta (Ascendente)
                xhttp.send(); // Realizar la petición
            }

            // Función para buscar un término dentro de la BD
            function busqueda() {
                // Petición AJAX para buscar datos en la BD
                var searchTerm = $('#search').val(); // Asigna el valor que existe en el input
                var xhr = new XMLHttpRequest();
                xhr.open('POST', './search.php'); // Abre el archivo que contiene la consulta
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Define el header de la petición
                xhr.onload = function() {
                    if (xhr.status === 200) { // La petición se ejecuta correctamente
                        var contenidoDiv = document.getElementById('contenido'); // Div que aloja el contenido 
                        contenidoDiv.outerHTML = xhr.responseText; // Cambia el contenido del div con el resultado de la consulta
                    }
                };
                xhr.send('search-term=' + encodeURIComponent(searchTerm)); // Asigna el término de búsqueda y realiza la petición
            }

        });
    </script>
</body>

</html>