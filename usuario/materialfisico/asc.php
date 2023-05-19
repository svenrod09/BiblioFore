<div id="contenido" class="row justify-content-center">
    <!-- Llenar cards con la información de la BD -->
    <?php

    // Trycatch para la selección de datos
    try {
        // Obtener la columna por la que se ordenarán los datos 
        $column = $_GET['column'];

        // Conexión con la BD
        include '../config.php';

        // Consulta de selección PostgreSQL
        $query = "SELECT mf.id AS id, mf.titulo, mf.descripcion, mf.autorid, CONCAT(au.nombre, ' ', au.apellido) 
        AS autor, mf.tipodocumentoid, td.nombre AS tipo, mf.editorialid, e.nombre AS editorial, mf.emisionyear AS year, 
        mf.imagen FROM materialfisico AS mf INNER JOIN autores au 
        ON mf.autorid = au.id INNER JOIN tipodocumento td ON mf.tipodocumentoid = td.id 
        INNER JOIN editoriales e ON mf.editorialid = e.id ORDER BY $column ASC";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Verifica si la consulta devuelve datos
        if ($stmt->rowCount() > 0) {
    ?>
            <div class="col-12 mb-3">
                <div class="list-group">
                    <?php
                    while ($row = $stmt->fetch()) { // Lista los datos de la BD
                    ?>
                        <a href="#" target="_blank" class="list-group-item">
                            <div class="row">
                                <div class="col-3">
                                    <div class="aspect-ratio ratio-1x1 justify-content-center align-items-center">
                                        <img src="../../admineditor/materialfisico/<?php echo $row['imagen'] ?>" class="img-fluid img-square img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-9 mt-2">
                                    <div class="container">
                                        <h5 class="fw-bold"><?php echo $row['titulo'] ?></h5>
                                        <p><span class="fw-bold">Autor: </span><?php echo $row['autor'] ?></p>
                                        <p><span class="fw-bold">Descripción: </span><?php echo $row['descripcion'] ?></p>
                                        <p><span class="fw-bold">Tipo: </span><?php echo $row['tipo'] ?></p>
                                        <p><span class="fw-bold">Editorial: </span><?php echo $row['editorial'] ?></p>
                                        <p><span class="fw-bold">Año de emisión: </span><?php echo $row['year'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
    <?php
        } else {
            noData(); // Mostrar mensaje indicando que no hay datos
        }
    } catch (PDOException $e) {
        noData(); // Mostrar mensaje indicando que no hay datos
    }

    // Función para mostrar mensaje en pantalla indicando que no hay datos
    function noData()
    {
        // Mostrar mensaje en pantalla indicando que no hay datos
        echo '<div id="no-data" class="col-12 mb-3">
        <div class="no-data-card text-center mt-5">
            <h4 class="fw-bold">NADA POR AQUÍ...</h4>
            <p class="mb-2">No hay datos para mostrar :(</p>
            <img class="nodata-img" src="../resources/img/nodata.png">
        </div>
    </div>';
    }
    ?>

</div>