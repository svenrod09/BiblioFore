<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['user'])) { // Si no existen credenciales de la sesión
    session_unset();
    session_destroy(); // Cerrar sesión
    header("Location: https://login.unacifor.edu.hn"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    exit;
}
?>

<div id="contenido" class="row justify-content-center">
    <!-- Llenar datos con la información de la BD -->
    <?php

    // Trycatch para la selección de datos
    try {
        // Obtener el id por el que se filtrarán los datos 
        $id = $_GET['id'];

        // Obtener la categoría por la que se ordenarán los datos 
        $category = $_GET['category'];

        // Conexión con la BD
        include '../../../../config.php';

        // Consulta de selección PostgreSQL
        $query = "SELECT mf.id AS id, mf.titulo, mf.descripcion, mf.autorid, CONCAT(au.nombre, ' ', au.apellido) 
        AS autor, mf.tipodocumentoid, td.nombre AS tipo, mf.editorialid, e.nombre AS editorial, mf.emisionyear AS year, 
        mf.imagen FROM materialfisico AS mf INNER JOIN autores au 
        ON mf.autorid = au.id INNER JOIN tipodocumento td ON mf.tipodocumentoid = td.id 
        INNER JOIN editoriales e ON mf.editorialid = e.id WHERE mf.autorid = :id AND mf.tipodocumentoid = :category ORDER BY titulo ASC";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Asignar valores
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':category', $category);

        // Ejecutar la consulta
        $stmt->execute();

        // Verifica si la consulta devuelve datos
        if ($stmt->rowCount() > 0) {
    ?>
            <div class="col-12 mb-3">
                <div class="list-group">
                    <p><span><a href="#" id=resetFilter><i class="fas fa-arrow-left fs-2 text-dark me-2"></i></a><p>Mostrando <span class="badge theme-bg fw-bold"><?php echo $stmt->rowCount(); ?></span> resultados.</p>
                    <?php
                    while ($row = $stmt->fetch()) { // Lista los datos de la BD
                    ?>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#verModal" data-title="<?php echo $row['titulo'] ?>" data-aut="<?php echo $row['autor'] ?>" data-desc="<?php echo $row['descripcion'] ?>" data-type="<?php echo $row['tipo'] ?>" data-edit="<?php echo $row['editorial'] ?>" data-year="<?php echo $row['year'] ?>" data-image="../../../admin/catalogofisico/<?php echo $row['imagen'] ?>" class="list-group-item open-modal">
                            <div class="row">
                                <div class="col-3">
                                    <div class="aspect-ratio ratio-1x1 justify-content-center align-items-center">
                                        <img src="../../../admin/catalogofisico/<?php echo $row['imagen'] ?>" class="img-fluid img-square img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-7 mt-2">
                                    <div class="container">
                                        <h5 class="fw-bold"><?php echo $row['titulo'] ?></h5>
                                        <p><span class="fw-bold">Autor: </span><span class="bg-warning text-dark"><?php echo $row['autor'] ?></span></p>
                                        <p><span class="fw-bold">Descripción: </span><?php echo $row['descripcion'] ?></p>
                                        <p><span class="fw-bold">Categoría: </span><?php echo $row['tipo'] ?></p>
                                        <p><span class="fw-bold">Editorial: </span><?php echo $row['editorial'] ?></p>
                                        <p><span class="fw-bold">Año de emisión: </span><?php echo $row['year'] ?></p>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <div class="text-center">
                                        <i class="fas fa-arrow-right fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>

                <!-- Modal para ver los datos del Catálogo -->
                <div class="modal fade" id="verModal" tabindex="-1" role="dialog" aria-labelledby="verModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="verModal"><i class="fas fa-book fa-fw me-2"></i>Catálogo Físico</h5>
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
                            <div class="modal-footer justify-content-center">
                                <h5 class="fw-bold text-center text-success">¡Disponible en la biblioteca física de la universidad!</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        echo '<div id="no-data" class="col-12 mb-3">
        <div class="no-data-card text-center mt-5">
            <h4 class="fw-bold">NADA POR AQUÍ...</h4>
            <p class="mb-2">No hay datos para mostrar :(</p>
            <img class="nodata-img" src="../../resources/img/nodata.png">
        </div>
    </div>';
    }
        ?>

            </div>