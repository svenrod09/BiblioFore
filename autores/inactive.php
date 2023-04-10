<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // Si no existen credenciales de la sesión
    session_unset();
    session_destroy(); // Cerrar sesión
    header("Location: ../login.php"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    exit;
} else {
    // Si un usuario de tipo = 2 (Editor) intenta acceder aquí se le redireccionará a donde tiene permitido
    if ($_SESSION['user_type'] == 2) {
        $_SESSION['permission_alert'] = "No tiene permisos para acceder a este apartado."; // Envía un mensaje de alerta
        header("Location: ./index.php"); // Redirección a la página de inicio
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

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../css/adminStyles.css">

    <title>BiblioFore | Autores</title>

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
                        <i class="fas fa-pen-fancy fs-4 fa-fw activo items-color"></i>
                        <span class="ms-2 d-none d-sm-inline activo fw-bold">Autores</span></a>

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
                        <i class="fas fa-book fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Catálogo Físico</span></a>

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
                                <h1 class="text-center fw-bold">Control de Autores</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para editar los registros que están habilitados -->
                    <a href="./index.php" class="btn btn-primary mb-3"><i class="fas fa-eye me-2"></i>Editar Activos</a>

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
                                    <th scope="col" class="text-center">Nombre</th>
                                    <th scope="col" class="text-center">Apellido</th>
                                    <th scope="col" class="text-center">Nacionalidad</th>
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
                                    $query = "SELECT * FROM autores WHERE disponible = false";

                                    // Preparar consulta
                                    $stmt = $db->prepare($query);

                                    // Ejecutar la consulta
                                    $stmt->execute();

                                    while ($row = $stmt->fetch()) { // Muestra los datos de la BD  en la tabla
                                ?>
                                        <tr>
                                            <th class="text-center"><?php echo $row['id'] ?></th>
                                            <th class="text-center"><?php echo $row['nombre'] ?></th>
                                            <th class="text-center"><?php echo $row['apellido'] ?></th>
                                            <th class="text-center"><?php echo $row['paisdenacimiento'] ?></th>
                                            <td class="text-center">
                                                <!-- Restaurar (al hacer clic se envían a los modal los parámetros necesarios) -->
                                                <a href="#" data-toggle="tooltip" title="Restaurar" data-bs-toggle="modal" data-bs-target="#restaurarModal" data-id="<?php echo $row['id'] ?>" data-last="<?php echo $row['apellido'] ?>" data-name="<?php echo $row['nombre'] ?>" class="link-dark open-restore tooltip-link"><i class="fas fa-redo-alt fs-5 me-3"></i></a>
                                                <!-- Eliminar (al hacer clic se envían a los modal los parámetros necesarios) -->
                                                <a href="#" data-toggle="tooltip" title="Eliminar" data-bs-toggle="modal" data-bs-target="#eliminarModal" data-id="<?php echo $row['id'] ?>" data-last="<?php echo $row['apellido'] ?>" data-name="<?php echo $row['nombre'] ?>" class="link-dark open-delete tooltip-link"><i class="fas fa-trash fs-5 me-3"></i></a>
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

                    <!-- Modal para Restaurar Registro -->
                    <div class="modal fade" id="restaurarModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-redo-alt fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold">Restaurar Autor:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Realmente deseas restaurar el autor <strong id="name-restore"></strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle me-2"></i></i>Cancelar</button>
                                    <button type="button" id="restore" class="btn btn-dark"><i class="fas fa-redo-alt me-2"></i>Restaurar</button>
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
                                    <h5 class="modal-title fw-bold">Eliminar Autor:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Realmente deseas eliminar de forma permanente el autor <strong id="name-delete"></strong>?
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

            // Restablecer Registro BD
            $('.open-restore').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var last = $(this).data('last')
                var nombre = $(this).data('name');
                $("#name-restore").html(nombre + ' ' + last);

                // Confirmar restauración
                $('#restore').click(function() {
                    $.ajax({ // Petición AJAX
                        type: "POST", // Método POST
                        url: "restore.php", // Archivo que contiene la consulta de actualización
                        data: { // Enviar datos
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) { // Restauración correcta
                                $("#restaurarModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").removeClass("alert-danger");
                                $("#alertMessage").html("¡Correcto! Se restableció el registro correctamente :D").addClass("alert-success").fadeIn();
                                setTimeout(function() {
                                    $("#alertMessage").fadeOut();
                                    refrescarTabla();
                                }, 2000);
                            } else { // Actualización fallida
                                $("#restaurarModal").modal("hide"); // Ocultar Modal
                                // Enviar alerta
                                $("#alertMessage").html("¡Error! No se pudo restaurar el registro :(").addClass("alert-danger").fadeIn();
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

            // Eliminar Registro BD
            $('.open-delete').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var last = $(this).data('last');
                var nombre = $(this).data('name');
                $("#name-delete").html(nombre + ' ' + last);

                // Confirmar eliminación
                $('#delete').click(function() {
                    $.ajax({ // Petición AJAX
                        type: "POST", // Método POST
                        url: "delete.php", // Archivo que contiene la consulta de eliminación
                        data: { // Enviar datos
                            id: id
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
        });
    </script>
</body>

</html>