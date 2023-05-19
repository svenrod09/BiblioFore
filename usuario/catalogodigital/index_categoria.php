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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle activo" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="nav-link" target="_blank" href="../help/index.php">
                            <i class="fas fa-question-circle fs-5 fa-fw"></i>
                            <span class="ms-2 fs-5 fw-bold">Ayuda</span>
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

        <div class="row">
            <!-- Barra de búsqueda -->
            <div class="col-12 col-md-8 mb-3">
                <div class="input-group">
                    <input id="search" type="text" class="form-control" placeholder="Buscar">
                    <div class="input-group-append">
                        <button id="searchBtn" class="btn btn-outline-theme" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                        <!--<button id="resetSearch" type="button" class="btn btn-theme">Reiniciar</button>-->
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
                <div class="list-group mb-3">
                    <a href="./index.php" class="list-group-item fw-bold">
                        <span>Título</span>
                    </a>
                    <a href="./index_autor.php" class="list-group-item fw-bold">
                        <span>Autor</span>
                    </a>
                    <a href="./index_descripcion.php" class="list-group-item fw-bold">
                        <span>Descripción</span>
                    </a>
                    <a href="#" id="order" class="list-group-item active-list fw-bold">
                        <i id="ordericon" class="fas fa-arrow-up"></i>
                        <span class="ms-2">Categoría</span>
                    </a>
                    <a href="./index_editorial.php" class="list-group-item fw-bold">
                        <span>Editorial</span>
                    </a>
                    <a href="./index_year.php" class="list-group-item fw-bold">
                        <span>Año de Emisión</span>
                    </a>
                </div>

                <!-- Select para filtrar datos -->
                <div class="form-group mb-3">
                    <h4 class="fw-bold">Filtrar por:</h4>
                    <div class="input-group">
                        <select class="form-select" id="filterSelect">
                            <option value="0">Seleccione una opción</option>
                            <option value="1">Autor</option>
                            <option value="2">Nacionalidad del Autor</option>
                            <option value="3">Descripción</option>
                            <option value="4">Categoría</option>
                            <option value="5">Editorial</option>
                            <option value="6">Año de Emisión</option>
                        </select>
                        <!--<button id="resetFilter" type="button" class="btn btn-theme">Reiniciar</button>-->
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
            var ascendente = true; // Ordenamiento ascendente por defecto (A-Z)

            ordenarASC(); // Ordenar los datos de forma ascendente

            // Llenar los submenú del navbar al dar click
            // Catálogo Digital
            $('#navbarDropdown').click(function() {
                $('#subMenuDigital').load('../submenu/submenu_digital.php');
            });

            // Catálogo Físico
            $('#navbarDropdown1').click(function() {
                $('#subMenuFisico').load('../submenu/submenu_fisico.php');
            });

            // Obtener el id del botón e ícono de ordenamiento
            const ordenarButton = document.getElementById('order');
            const ordenarIcon = document.getElementById('ordericon');

            // Cambia el ordenamiento de los datos al dar click en el panel lateral de ordenar por
            ordenarButton.addEventListener('click', function() {
                if (ascendente === true) {
                    ascendente = false; // Ordenamiento descendente (Z-A)
                    $('#filterSelect').val("0"); // Reinicia los filtros
                    ordenarIcon.classList.remove('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.add('fa-arrow-down'); // Cambia el ícono de ordenamiento

                    // Petición AJAX para ordenar los datos
                    var columna = "tipo"; // Columna de la BD por la que se desea ordenar los datos
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
                    $('#filterSelect').val("0"); // Reinicia los filtros
                    ordenarIcon.classList.remove('fa-arrow-down'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.add('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarASC(); // Ordenar los datos de forma ascendente
                }
            });

            // Al hacer cambios en el select se filtran los datos
            $('#filterSelect').on('change', function() {
                var opcion = $(this).val(); // Opción seleccionada
                if (opcion === '0') { // Filtrado por defecto
                    ascendente = true; // Ordenar los datos de forma ascendente
                    ordenarIcon.classList.remove('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.remove('fa-arrow-down'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.add('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarASC(); // Ordenar los datos de forma ascendente
                } else if (opcion === '1') { // Filtrado por autor
                    var carpeta = "autores";
                    filtro(carpeta); // Filtra los datos
                } else if (opcion === '2') { // Filtrado por nacionalidad del autor
                    var carpeta = "autores";
                    var archivo = "nacionalidades";
                    filtroDoble(carpeta, archivo); // Filtra los datos
                } else if (opcion === '3') { // Filtrado por descripción
                    var carpeta = "descripciones";
                    filtro(carpeta); // Filtra los datos
                } else if (opcion === '4') { // Filtrado por categoría
                    var carpeta = "tipos";
                    filtro(carpeta); // Filtra los datos
                } else if (opcion === '5') { // Filtrado por editorial
                    var carpeta = "editoriales";
                    filtro(carpeta); // Filtra los datos
                } else if (opcion === '6') { // Filtrado por año de emisión
                    var carpeta = "years";
                    filtro(carpeta); // Filtra los datos
                }
            });

            // Al presionar el botón de buscar se realiza la búsqueda 
            $('#searchBtn').click(function() {
                var inputSearch = $('#search').val(); // Obtiene el valor del input de búsqueda
                if (inputSearch === '') { // El input está vacío
                    ascendente = true; // Ordenar los datos de forma ascendente
                    ordenarIcon.classList.remove('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.remove('fa-arrow-down'); // Cambia el ícono de ordenamiento
                    ordenarIcon.classList.add('fa-arrow-up'); // Cambia el ícono de ordenamiento
                    ordenarASC(); // Ordenar los datos de forma ascendente 
                } else { // El input no está vacío
                    busqueda(); // Realiza la búsqueda
                }
            });

            // Al hacer click en la flecha de volver atrás, ordena los datos de forma ascendente dependiendo de la columna por la que se esté ordenando (A-Z)
            $(document).on('click', '#resetFilter', function() {
                ascendente = true; // Ordenar los datos de forma ascendente
                $('#filterSelect').val("0"); // Reinicia los filtros
                ordenarIcon.classList.remove('fa-arrow-up'); // Cambia el ícono de ordenamiento
                ordenarIcon.classList.remove('fa-arrow-down'); // Cambia el ícono de ordenamiento
                ordenarIcon.classList.add('fa-arrow-up'); // Cambia el ícono de ordenamiento
                ordenarASC(); // Ordenar los datos de forma ascendente
            });

            // Al hacer click en la flecha de volver atrás, ordena los datos de forma ascendente dependiendo de la columna por la que se esté ordenando (A-Z)
            $(document).on('click', '#resetSearch', function() {
                ascendente = true; // Ordenar los datos de forma ascendente
                $('#filterSelect').val("0"); // Reinicia los filtros
                ordenarIcon.classList.remove('fa-arrow-up'); // Cambia el ícono de ordenamiento
                ordenarIcon.classList.remove('fa-arrow-down'); // Cambia el ícono de ordenamiento
                ordenarIcon.classList.add('fa-arrow-up'); // Cambia el ícono de ordenamiento
                ordenarASC(); // Ordenar los datos de forma ascendente
            });

            // Al hacer click en la lista de filtros, filtra los datos dependiendo del ítem que se selccione
            $(document).on('click', '.filtrardatos', function() {
                var id = $(this).data('id'); // ID del filtro
                var folder = $(this).data('folder'); // Directorio donde se encuentra el archivo de consulta
                var file = $(this).data('file'); // Archivo que contiene la consulta
                filtrarData(id, folder, file); // Filtra los datos
            });

            // Función para ordenar los datos de forma ascendente (A-Z)
            function ordenarASC() {
                // Petición AJAX para ordenar los datos
                var columna = "tipo"; // Columna de la BD por la que se desea ordenar los datos
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

            // Función para filtrar los resultados dependiendo del campo que se elija
            function filtro(filtro) { // Parámetro que contiene la carpeta y el archivo donde se aloja la consulta de filtrado
                // Petición AJAX para filtrar los datos
                var contenidoDiv = document.getElementById('contenido'); // Div que aloja el contenido 
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) { // La petición se ejecuta correctamente
                        contenidoDiv.outerHTML = this.responseText; // Cambia el contenido del div con el resultado de la consulta
                    }
                };
                xhttp.open("GET", "./filter/" + filtro + "/" + filtro + ".php", true); // Archivo que contiene la consulta 
                xhttp.send(); // Realizar la petición
            }

            // Función para filtrar los resultados dependiendo del campo que se elija
            function filtroDoble(carpeta, filtro) { // Parámetro que contiene la carpeta y el archivo donde se aloja la consulta de filtrado
                // Petición AJAX para filtrar los datos
                var contenidoDiv = document.getElementById('contenido'); // Div que aloja el contenido 
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) { // La petición se ejecuta correctamente
                        contenidoDiv.outerHTML = this.responseText; // Cambia el contenido del div con el resultado de la consulta
                    }
                };
                xhttp.open("GET", "./filter/" + carpeta + "/" + filtro + ".php", true); // Archivo que contiene la consulta 
                xhttp.send(); // Realizar la petición
            }

            // Función para filtrar los datos dependiendo de los parámetros recibidos
            function filtrarData(id, carpeta, archivo) {
                // Petición AJAX para filtrar los datos
                var contenidoDiv = document.getElementById('contenido'); // Div que aloja el contenido 
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) { // La petición se ejecuta correctamente
                        contenidoDiv.outerHTML = this.responseText; // Cambia el contenido del div con el resultado de la consulta
                    }
                };
                xhttp.open("GET", "./filter/" + carpeta + "/" + archivo + ".php?id=" + encodeURIComponent(id), true); // Archivo que contiene la consulta 
                xhttp.send(); // Realizar la petición
            }
        });
    </script>
</body>

</html>