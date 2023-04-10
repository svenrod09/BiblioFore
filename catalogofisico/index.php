<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // Si no existen credenciales de la sesión
    session_unset();
    session_destroy(); // Cerrar sesión
    header("Location: ../login.php"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    exit;
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

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../css/adminStyles.css">

    <title>BiblioFore | Catálogo Físico</title>

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

                    <a href="../adminPage.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-home fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Inicio</span></a>

                    <a href="../usuarios/index.php" id="usuarios" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-users fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Usuarios</span></a>

                    <a href="../autores/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-pen-fancy fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Autores</span></a>

                    <a href="../editoriales/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-university fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Editoriales</span></a>

                    <a href="../tipodocumento/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-file fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Tipos</span></a>

                    <a href="../catalogodigital/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-laptop fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Catálogo Digital</span></a>

                    <a href="../catalogofisico/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-book fs-4 fa-fw activo items-color"></i>
                        <span class="ms-2 d-none d-sm-inline activo fw-bold">Catálogo Físico</span></a>

                    <a href="../referencias/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-quote-right fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Referencias Externas</span></a>

                    <a href="../basesbibliotecas/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-book-reader fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Bibliotecas Externas</span></a>

                    <a href="../logout.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-arrow-left fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Salir</span></a>
                </div>
            </div>
            <!-- Contenido -->
            <div id="content-area" class="col py-3">
                <div class="container">
                    <!-- Encabezado -->
                    <div class="container py-2">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <h1 class="text-center fw-bold">
                                    <i class="fas fa-book me-2"></i>Control de Catálogo Físico
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para desplegar form de nuevo registro -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#nuevoModal" class="btn btn-success mb-3"><i class="fas fa-plus me-2"></i>Nuevo</a>

                    <!-- Alerta para saber si se ingresaron o no los datos a la BD -->
                    <div class="alert" role="alert" id="alertMessage" style="display:none;">
                    </div>

                    <!-- Tabla para mostrar datos de la BD -->
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                            <thead class="theme-bg">
                                <tr class="text-light">
                                    <!-- Encabezados de la tabla -->
                                    <th scope="col" class="text-center">ID</th>
                                    <th scope="col" class="text-center">Título</th>
                                    <th scope="col" class="text-center">Descripción</th>
                                    <th scope="col" class="text-center">Autor</th>
                                    <th scope="col" class="text-center">Tipo</th>
                                    <th scope="col" class="text-center">Editorial</th>
                                    <th scope="col" class="text-center">Año</th>
                                    <th scope="col" class="text-center">Imagen</th>
                                    <th scope="col" class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Llenar la tabla con la información de la BD -->
                                <?php

                                // Trycatch para la selección de datos
                                try {
                                    // Conexión con la BD
                                    include '../config.php';

                                    // Consulta de selección PostgreSQL
                                    $query = "SELECT mf.id AS id, mf.titulo, mf.descripcion, mf.autorid, CONCAT(au.nombre, ' ', au.apellido) 
                                    AS autor, mf.tipodocumentoid, td.nombre AS tipo, mf.editorialid, e.nombre AS editorial, mf.emisionyear AS year, 
                                    mf.imagen FROM materialfisico AS mf INNER JOIN autores au 
                                    ON mf.autorid = au.id INNER JOIN tipodocumento td ON mf.tipodocumentoid = td.id 
                                    INNER JOIN editoriales e ON mf.editorialid = e.id";

                                    // Preparar consulta
                                    $stmt = $db->prepare($query);

                                    // Ejecutar la consulta
                                    $stmt->execute();

                                    while ($row = $stmt->fetch()) { // Muestra los datos de la BD  en la tabla
                                ?>
                                        <tr>
                                            <th class="text-center"><?php echo $row['id'] ?></th>
                                            <th class="text-center"><?php echo $row['titulo'] ?></th>
                                            <th class="text-center"><?php echo $row['descripcion'] ?></th>
                                            <th class="text-center"><?php echo $row['autor'] ?></th>
                                            <th class="text-center"><?php echo $row['tipo'] ?></th>
                                            <th class="text-center"><?php echo $row['editorial'] ?></th>
                                            <th class="text-center"><?php echo $row['year'] ?></th>
                                            <td class="text-center">
                                                <!-- Actualizar imagen (se envían parámetros a los modal al hacer clic) -->
                                                <a href="#" data-toggle="tooltip" title="Actualizar" data-bs-toggle="modal" data-bs-target="#editarImagenModal" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['titulo'] ?>" data-image="<?php echo $row['imagen'] ?>" class="link-dark tooltip-link edit-image"><i class="fas fa-sync-alt fs-5 me-3"></i></a>
                                                <!-- Ver imagen -->
                                                <a href="./<?php echo $row['imagen'] ?>" target="_blank" data-toggle="tooltip" title="Ver" class="link-dark tooltip-link"><i class="fas fa-eye fs-5 me-3"></i></a>
                                                <!-- Descargar imagen (se envían parámetros a los modal al hacer clic) -->
                                                <a href="./download.php?file=<?php echo $row['imagen'] ?>" target="_blank" data-toggle="tooltip" title="Descargar" class="link-dark tooltip-link"><i class="fas fa-download fs-5 me-3"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <!-- Editar (se envían parámetros a los modal al hacer clic) -->
                                                <a href="#" data-toggle="tooltip" title="Editar" data-bs-toggle="modal" data-bs-target="#editarModal" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['titulo'] ?>" data-desc="<?php echo $row['descripcion'] ?>" data-aut="<?php echo $row['autorid'] ?>" data-tipo="<?php echo $row['tipodocumentoid'] ?>" data-edit="<?php echo $row['editorialid'] ?>" data-year="<?php echo $row['year'] ?>" class="link-dark open-edit tooltip-link"><i class="fas fa-edit fs-5 me-3"></i></a>
                                                <!-- Eliminar (se envían parámetros a los modal al hacer clic) -->
                                                <a href="#" data-toggle="tooltip" title="Eliminar" data-bs-toggle="modal" data-bs-target="#eliminarModal" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['titulo'] ?>" data-image="<?php echo $row['imagen'] ?>" class="link-dark open-delete tooltip-link"><i class="fas fa-trash fs-5 me-3"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } catch (PDOException $e) {
                                    // Si algo falla manda un mensaje con el error
                                    echo '<script>alert("¡Error al mostrar los datos! Contacte al administrador. " ' . $e->getMessage() . ')</script>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal para Nuevo Registro -->
                    <div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-plus-square fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold" id="nuevoModalLabel">Nuevo Material Físico:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="nuevoRegistroForm" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-style input-valid" title="Ingrese el título del material." name="nombreC" id="nombreC" placeholder="Título del Material">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-style input-valid" title="Ingrese una descripción/categoría del material (Ejemplo: Ciencias forestales)." name="descC" id="descC" placeholder="Descripción/Categoría del Material">
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="autorC">Autor:</label>
                                            <div class="input-group">
                                                <select class="form-select" name="autorC" id="autorC">
                                                    <option value="0">Seleccione un autor</option>
                                                    <?php include('./select/autores.php');  ?> <!-- Llena el select con el listado de datos obtenidos de la BD -->
                                                </select>
                                                <span class="input-group-addon">
                                                    <a href="../autores/index.php" class="link-dark"><i data-toggle="tooltip" title="Seleccione un autor. Si no encuentras el autor que buscas, ingrésalo desde la sección de Autores." class="fas fa-question-circle fs-5 ms-2 mt-2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="tipoC">Tipo de Documento:</label>
                                            <div class="input-group">
                                                <select class="form-select" name="tipoC" id="tipoC">
                                                    <option value="0">Seleccione un tipo de documento</option>
                                                    <?php include('./select/tipos.php');  ?> <!-- Llena el select con el listado de datos obtenidos de la BD -->
                                                </select>
                                                <span class="input-group-addon">
                                                    <a href="../tipodocumento/index.php" class="link-dark"><i data-toggle="tooltip" title="Seleccione un tipo de documento. Si no encuentras el tipo que buscas, ingrésalo desde la sección de Tipos." class="fas fa-question-circle fs-5 ms-2 mt-2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="editorialC">Editorial:</label>
                                            <div class="input-group">
                                                <select class="form-select" name="editorialC" id="editorialC">
                                                    <option value="0">Seleccione una editorial</option>
                                                    <?php include('./select/editoriales.php');  ?> <!-- Llena el select con el listado de datos obtenidos de la BD -->
                                                </select>
                                                <span class="input-group-addon">
                                                    <a href="../editoriales/index.php" class="link-dark"><i data-toggle="tooltip" title="Seleccione una editorial. Si no encuentras la editorial que buscas, ingrésala desde la sección de Editoriales." class="fas fa-question-circle fs-5 ms-2 mt-2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="yearC">Año de Emisión:</label>
                                            <select class="form-select" name="yearC" id="yearC">
                                                <option value="0">Seleccione un año</option>
                                                <?php include('./select/years.php');  ?> <!-- Llena el select con el listado de años obtenidos -->
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="imgC">Imagen del Material (10MB máximo):</label>
                                            <input accept="image/png,image/jpeg,image/webp" type="file" class="form-control input-style input-valid" name="imgC" id="imgC" placeholder="Imagen del Material">
                                        </div>
                                        <div class="justify-content-center text-center">
                                            <p id="errormsgC" class="d-none text-danger fw-bold">Revise los datos ingresados.</p>
                                        </div>
                                        <div class="progress" style="display:none;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle me-2"></i></i>Cerrar</button>
                                    <button type="button" id="submit" class="btn btn-dark" disabled><i class="fas fa-save me-2"></i>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para Editar Registro -->
                    <div class="modal fade" id="editarModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-edit fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold">Editar Material Físico:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editarRegistroForm">
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-style input-valid" title="Ingrese el título del material." name="nombreE" id="nombreE" placeholder="Título del Material">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-style input-valid" title="Ingrese una descripción/categoría del material (Ejemplo: Ciencias forestales)." name="descE" id="descE" placeholder="Descripción/Categoría del Material">
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="autorE">Autor:</label>
                                            <div class="input-group">
                                                <select class="form-select" name="autorE" id="autorE">
                                                    <option value="0">Seleccione un autor</option>
                                                    <?php include('./select/autores.php');  ?> <!-- Llena el select con el listado de datos obtenidos de la BD -->
                                                </select>
                                                <span class="input-group-addon">
                                                    <a href="../autores/index.php" class="link-dark"><i data-toggle="tooltip" title="Seleccione un autor. Si no encuentras el autor que buscas, ingrésalo desde la sección de Autores." class="fas fa-question-circle fs-5 ms-2 mt-2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="tipoE">Tipo de Documento:</label>
                                            <div class="input-group">
                                                <select class="form-select" name="tipoE" id="tipoE">
                                                    <option value="0">Seleccione un tipo de documento</option>
                                                    <?php include('./select/tipos.php');  ?> <!-- Llena el select con el listado de datos obtenidos de la BD -->
                                                </select>
                                                <span class="input-group-addon">
                                                    <a href="../tipodocumento/index.php" class="link-dark"><i data-toggle="tooltip" title="Seleccione un tipo de documento. Si no encuentras el tipo que buscas, ingrésalo desde la sección de Tipos." class="fas fa-question-circle fs-5 ms-2 mt-2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="editorialE">Editorial:</label>
                                            <div class="input-group">
                                                <select class="form-select" name="editorialE" id="editorialE">
                                                    <option value="0">Seleccione una editorial</option>
                                                    <?php include('./select/editoriales.php');  ?> <!-- Llena el select con el listado de datos obtenidos de la BD -->
                                                </select>
                                                <span class="input-group-addon">
                                                    <a href="../editoriales/index.php" class="link-dark"><i data-toggle="tooltip" title="Seleccione una editorial. Si no encuentras la editorial que buscas, ingrésala desde la sección de Editoriales." class="fas fa-question-circle fs-5 ms-2 mt-2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="yearE">Año de Emisión:</label>
                                            <select class="form-select" name="yearE" id="yearE">
                                                <option value="0">Seleccione un año</option>
                                                <?php include('./select/years.php');  ?> <!-- Llena el select con el listado de años obtenidos -->
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle me-2"></i></i>Cerrar</button>
                                    <button type="button" id="edit" class="btn btn-dark"><i class="fas fa-save me-2"></i>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para Editar Imagen del Registro -->
                    <div class="modal fade" id="editarImagenModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-edit fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold">Editar Imagen del Material Físico:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editarImagenForm" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="fw-bold" for="nombreEI">Título del Material:</label>
                                            <input type="text" class="form-control input-style input-valid" title="Ingrese el título del material." name="nombreEI" id="nombreEI" placeholder="Título del Material" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold" for="imgE">Imagen del Material (10MB máximo):</label>
                                            <input accept="image/png,image/jpeg,image/webp" type="file" class="form-control input-style input-valid" name="imgE" id="imgE" placeholder="Imagen del Material">
                                        </div>
                                        <div class="justify-content-center text-center">
                                            <p id="errormsgEI" class="d-none text-danger fw-bold">Suba un archivo de imagen (10MB máximo).</p>
                                        </div>
                                        <div class="progress" style="display:none;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle me-2"></i></i>Cerrar</button>
                                    <button type="button" id="editImage" class="btn btn-dark" disabled><i class="fas fa-save me-2"></i>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para Eliminar Registro -->
                    <div class="modal fade" id="eliminarModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-trash-alt fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold">Eliminar Material Físico:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Realmente deseas eliminar <strong id="name-delete"></strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"><i class="fas fa-times-circle me-2"></i></i>Cancelar</button>
                                    <button type="button" id="delete" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <!-- jQuery DataTables -->
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.js"></script>

    <!-- Funcionalidad -->
    <script>
        $(document).ready(function() {
            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Definir tabla como jQuery Datatable
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.3/i18n/es-ES.json"
                }
            });

            // Obtener mensajes de error, inputs y botón de guardar
            // Inputs
            var nombreC = document.getElementById('nombreC');
            var nombreE = document.getElementById('nombreE');
            var descC = document.getElementById('descC');
            var descE = document.getElementById('descE');
            var autorC = document.getElementById('autorC');
            var autorE = document.getElementById('autorE');
            var tipoC = document.getElementById('tipoC');
            var tipoE = document.getElementById('tipoE');
            var editorialC = document.getElementById('editorialC');
            var editorialE = document.getElementById('editorialE');
            var yearC = document.getElementById('yearC');
            var yearE = document.getElementById('yearE');
            var imgC = document.getElementById('imgC');
            var imgE = document.getElementById('imgE');
            // Buttons
            var btnGuardar = document.getElementById('submit');
            var btnEditar = document.getElementById('edit');
            var btnEditarImagen = document.getElementById('editImage');
            // Mensajes de error
            var msgErrorC = document.getElementById('errormsgC');
            var msgErrorE = document.getElementById('errormsgE');
            var msgErrorEI = document.getElementById('errormsgEI');

            // Validar inputs de modal guardar al realizar cambios en ellos
            nombreC.addEventListener('input', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            descC.addEventListener('input', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            autorC.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            tipoC.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            editorialC.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            yearC.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            imgC.addEventListener('change', function() {
                // Validar que el tamaño del archivo no sea superior a 10MB
                var archivo = this.files[0];
                var maxTamano = 10 * 1024 * 1024; // 10MB
                if (archivo.size > maxTamano) {
                    // El input no es válido, mostrar un mensaje de error
                    this.value = null; // limpiar el valor del input file
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                }
                // Validar que el input no esté vacío
                else if (nombreC.value == '' || descC.value == '' || autorC.value == 0 || tipoC.value == 0 ||
                    editorialC.value == 0 || yearC.value == 0 || imgC.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorC.classList.remove("d-none");
                    btnGuardar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorC.classList.add("d-none");
                    btnGuardar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            // Validar inputs de modal editar al realizar cambios en ellos
            nombreE.addEventListener('input', function() {
                // Validar que el input no esté vacío
                if (nombreE.value == '' || descE.value == '' || autorE.value == 0 || tipoE.value == 0 ||
                    editorialE.value == 0 || yearE.value == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            descE.addEventListener('input', function() {
                // Validar que el input no esté vacío
                if (nombreE.value == '' || descE.value == '' || autorE.value == 0 || tipoE.value == 0 ||
                    editorialE.value == 0 || yearE.value == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            autorE.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreE.value == '' || descE.value == '' || autorE.value == 0 || tipoE.value == 0 ||
                    editorialE.value == 0 || yearE.value == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            tipoE.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreE.value == '' || descE.value == '' || autorE.value == 0 || tipoE.value == 0 ||
                    editorialE.value == 0 || yearE.value == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            editorialE.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreE.value == '' || descE.value == '' || autorE.value == 0 || tipoE.value == 0 ||
                    editorialE.value == 0 || yearE.value == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            yearE.addEventListener('change', function() {
                // Validar que el input no esté vacío
                if (nombreE.value == '' || descE.value == '' || autorE.value == 0 || tipoE.value == 0 ||
                    editorialE.value == 0 || yearE.value == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            // Validar inputs de modal editar imagen
            imgE.addEventListener('change', function() {
                // Validar que el tamaño del archivo no sea superior a 10MB
                var archivo = this.files[0];
                var maxTamano = 10 * 1024 * 1024; // 10MB
                // Validar que el input no esté vacío
                if (imgE.files.length == 0) {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorEI.classList.remove("d-none");
                    btnEditarImagen.setAttribute("disabled", "");
                }
                // Validar que el tamaño del archivo no sea superior a 10MB 
                else if (archivo.size > maxTamano) {
                    // El input no es válido, mostrar un mensaje de error
                    this.value = null; // limpiar el valor del input file
                    msgErrorEI.classList.remove("d-none");
                    btnEditarImagen.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorEI.classList.add("d-none");
                    btnEditarImagen.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            // Nuevo Registro BD
            $("#submit").click(function() {
                // Obtener valores de los input
                var form = document.getElementById("nuevoRegistroForm");
                var formData = new FormData(form);

                $.ajax({ // Petición AJAX
                    // Cargar barra de progreso de subida de archivos
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                var porcentaje = event.loaded / event.total * 100;
                                $('.progress').show();
                                $('.progress-bar').width(porcentaje + '%');
                                $('.progress-bar').html(porcentaje.toFixed(0) + '%');
                            }
                        });
                        return xhr;
                    },
                    type: "POST", // Método POST
                    url: "create.php", // Archivo que contiene la consulta de inserción
                    data: formData, // Enviar datos
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) { // Inserción correcta
                            $("#nuevoModal").modal("hide"); // Ocultar Modal
                            // Enviar alerta 
                            $("#alertMessage").removeClass("alert-danger");
                            $("#alertMessage").html("¡Correcto! Se añadió el registro correctamente :D").addClass("alert-success").fadeIn();
                            resetearInput();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                                refrescarTabla();
                            }, 2000);
                            ocultarBarraDeProgreso();
                        } else { // Inserción fallida
                            $("#nuevoModal").modal("hide"); // Ocultar Modal
                            // Enviar alerta
                            $("#alertMessage").html("¡Error! No se pudo añadir el registro :(").addClass("alert-danger").fadeIn();
                            resetearInput();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                            }, 2000);
                            ocultarBarraDeProgreso();
                        }
                    },
                    error: function() {
                        $("#nuevoModal").modal("hide"); // Ocultar Modal
                        // Enviar alerta 
                        $("#alertMessage").html("¡Error! No se pudo procesar la solicitud :(").addClass("alert-danger").fadeIn();
                        resetearInput();
                        setTimeout(function() {
                            $("#alertMessage").fadeOut();
                        }, 2000);
                        ocultarBarraDeProgreso();
                    }
                });

            });

            // Editar Registro BD
            $('.open-edit').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var name = $(this).data('name');
                var desc = $(this).data('desc');
                var aut = $(this).data('aut');
                var tip = $(this).data('tipo');
                var edit = $(this).data('edit');
                var yr = $(this).data('year');
                $("#nombreE").val(name);
                $("#descE").val(desc);
                $("#autorE").val(aut);
                $("#tipoE").val(tip);
                $("#editorialE").val(edit);
                $("#yearE").val(yr);

                $('#edit').click(function() {
                    // Asignar valores
                    var titulo = $("#nombreE").val();
                    var descripcion = $("#descE").val();
                    var autor = $("#autorE").val();
                    var tipo = $("#tipoE").val();
                    var editorial = $("#editorialE").val();
                    var year = $("#yearE").val();
                    $.ajax({ // Petición AJAX
                        type: "POST", // Método POST
                        url: "update.php", // Archivo que contiene la consulta de edición
                        data: { // Enviar datos
                            id: id,
                            titulo: titulo,
                            descripcion: descripcion,
                            autor: autor,
                            tipo: tipo,
                            editorial: editorial,
                            year: year
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) { // Actualización correcta
                                $("#editarModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").removeClass("alert-danger");
                                $("#alertMessage").html("¡Correcto! Se actualizó el registro correctamente :D").addClass("alert-success").fadeIn();
                                resetearInput();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                    refrescarTabla();
                                }, 2000);
                            } else { // Actualización fallida
                                $("#editarModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").html("¡Error! No se pudo actualizar el registro :(").addClass("alert-danger").fadeIn();
                                resetearInput();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                }, 2000);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $("#editarModal").modal("hide"); // Ocultar Modal
                            // Enviar alerta 
                            console.log(errorThrown);
                            $("#alertMessage").html("¡Error! No se pudo procesar la solicitud :(").addClass("alert-danger").fadeIn();
                            resetearInput();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                            }, 2000);
                        }
                    });
                });
            });

            // Editar Imagen
            $('.edit-image').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var name = $(this).data('name');
                var imagen = $(this).data('image');
                $("#nombreEI").val(name);

                $('#editImage').click(function() {
                    // Obtener valores
                    var form = document.getElementById("editarImagenForm");
                    var formData = new FormData(form);
                    formData.append("id", id);
                    formData.append("imagenActual", imagen);

                    $.ajax({ // Petición AJAX
                        // Cargar barra de progreso de subida de archivos
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(event) {
                                if (event.lengthComputable) {
                                    var porcentaje = event.loaded / event.total * 100;
                                    $('.progress').show();
                                    $('.progress-bar').width(porcentaje + '%');
                                    $('.progress-bar').html(porcentaje.toFixed(0) + '%');
                                }
                            });
                            return xhr;
                        },
                        type: "POST", // Método POST
                        url: "updateimage.php", // Archivo que contiene la consulta de inserción
                        data: formData, // Enviar datos
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) { // Actualización correcta
                                $("#editarImagenModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta 
                                $("#alertMessage").removeClass("alert-danger");
                                $("#alertMessage").html("¡Correcto! Se actualizó el registro correctamente :D").addClass("alert-success").fadeIn();
                                resetearInput();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                    refrescarTabla();
                                }, 2000);
                                ocultarBarraDeProgreso();
                            } else { // Actualización fallida
                                $("#editarImagenModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").html("¡Error! No se pudo actualizar el registro :(").addClass("alert-danger").fadeIn();
                                resetearInput();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                }, 2000);
                                ocultarBarraDeProgreso();
                            }
                        },
                        error: function() {
                            $("#editarImagenModal").modal("hide"); // Ocultar Modal
                            // Enviar alerta 
                            $("#alertMessage").html("¡Error! No se pudo procesar la solicitud :(").addClass("alert-danger").fadeIn();
                            resetearInput();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                            }, 2000);
                            ocultarBarraDeProgreso();
                        }
                    });
                });
            });

            // Eliminar Registro BD
            $('.open-delete').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var nombre = $(this).data('name');
                var imagen = $(this).data('image');
                $("#name-delete").html(nombre);

                // Confirmar eliminación
                $('#delete').click(function() {
                    $.ajax({ // Petición AJAX
                        type: "POST", // Método POST
                        url: "delete.php", // Archivo que contiene la consulta de eliminación
                        data: { // Enviar datos
                            id: id,
                            imagen: imagen
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) { // Eliminación correcta
                                $("#eliminarModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").removeClass("alert-danger");
                                $("#alertMessage").html("¡Correcto! Se eliminó el registro correctamente :D").addClass("alert-success").fadeIn();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                    refrescarTabla();
                                }, 2000);
                            } else { // Eliminación fallida
                                $("#eliminarModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").html("¡Error! No se pudo eliminar el registro :(").addClass("alert-danger").fadeIn();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                }, 2000);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Enviar alerta 
                            console.log(errorThrown);
                            $("#alertMessage").html("¡Error! No se pudo procesar la solicitud :(").addClass("alert-danger").fadeIn();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                            }, 2000);
                        }
                    });
                });
            });

            // Función para actualizar los datos de una tabla después de una consulta
            function refrescarTabla() {
                location.reload();
            }

            // Función para reiniciar/ocultar la barra de progreso de subida de archivos
            function ocultarBarraDeProgreso() {
                $('.progress').hide();
                $('.progress-bar').width('0%');
                $('.progress-bar').html('0%');
            }

            // Función para resetear los valores de los input
            function resetearInput() {
                $("#nombreC").val('');
                $("#nombreE").val('');
                $("#descC").val('');
                $("#descE").val('');
                $("#autorC").val('');
                $("#autorE").val('');
                $("#tipoC").val('');
                $("#tipoE").val('');
                $("#editorialC").val('');
                $("#editorialE").val('');
                $("#yearC").val('');
                $("#yearE").val('');
                $("#imgC").val('');
                $("#imgE").val('');
            }
        });
    </script>
</body>

</html>