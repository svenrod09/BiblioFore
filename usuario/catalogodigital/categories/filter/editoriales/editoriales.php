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
        // Obtener la categoría por la que se ordenarán los datos 
        $category = $_GET['category'];
        
        // Conexión con la BD
        include '../../../../config.php';

        // Consulta de selección PostgreSQL
        $query = "SELECT DISTINCT e.id, e.nombre FROM materialdigital md INNER JOIN editoriales e ON
        md.editorialid = e.id WHERE md.tipodocumentoid = :category ORDER BY nombre ASC";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Asignar valores
        $stmt->bindValue(':category', $category);

        // Ejecutar la consulta
        $stmt->execute();

        // Verifica si la consulta devuelve datos
        if ($stmt->rowCount() > 0) {
    ?>
            <div class="col-12 mb-3">
                <div class="list-group">
                    <p><span><a href="#" id=resetFilter><i class="fas fa-arrow-left fs-2 text-dark me-2"></i></a></span> Mostrando <span class="badge theme-bg fw-bold"><?php echo $stmt->rowCount(); ?></span> resultados.</p>
                    <?php
                    while ($row = $stmt->fetch()) { // Lista los datos de la BD
                    ?>
                        <a href="#" data-id="<?php echo $row['id'] ?>" data-folder="editoriales" data-file="byeditorial" class="list-group-item filtrardatos h-100">
                            <div class="row">
                                <div class="col-10 mt-2">
                                    <div class="container">
                                        <p><span class="fw-bold"><?php echo $row['nombre'] ?></span></p>
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