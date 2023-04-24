<?php
// Verificar credenciales de la sesión
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // Si no existen credenciales de la sesión
    session_unset();
    session_destroy(); // Cerrar sesión
    header("Location: ../login.php"); // Redirigir al usuario a la página de inicio de sesión si no está autenticado
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

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../css/adminStyles.css">

    <title>BiblioFore | Editoriales</title>

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
                        <i class="fas fa-university fs-4 fa-fw activo items-color"></i>
                        <span class="ms-2 d-none d-sm-inline activo fw-bold">Editoriales</span></a>

                    <a href="../categorias/index.php" class="d-flex align-items-center pb-4 text-decoration-none items-color">
                        <i class="fas fa-file fs-4 fa-fw items-color"></i>
                        <span class="ms-2 d-none d-sm-inline fw-bold">Categorías</span></a>

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
                                <h1 class="text-center fw-bold">
                                    <i class="fas fa-university me-2"></i>Control de Editoriales
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para desplegar form de nuevo registro -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#nuevoModal" class="btn btn-success mb-3"><i class="fas fa-plus me-2"></i>Nuevo</a>
                    <!-- Botón para editar los registros que han sido deshabilitados -->
                    <a href="./inactive.php" class="btn btn-primary mb-3"><i class="fas fa-low-vision me-2"></i>Editar Inactivos</a>

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
                                    <th scope="col" class="text-center">Nombre Editorial</th>
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
                                    $query = "SELECT * FROM editoriales WHERE disponible = true";

                                    // Preparar consulta
                                    $stmt = $db->prepare($query);

                                    // Ejecutar la consulta
                                    $stmt->execute();

                                    while ($row = $stmt->fetch()) { // Muestra los datos de la BD  en la tabla
                                ?>
                                        <tr>
                                            <th class="text-center"><?php echo $row['id'] ?></th>
                                            <th class="text-center"><?php echo $row['nombre'] ?></th>
                                            <td class="text-center">
                                                <!-- Editar (al hacer clic se envían a los modal los parámetros necesarios) -->
                                                <a href="#" data-toggle="tooltip" title="Editar" data-bs-toggle="modal" data-bs-target="#editarModal" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['nombre'] ?>" class="link-dark open-edit tooltip-link"><i class="fas fa-edit fs-5 me-3"></i></a>
                                                <!-- Eliminar (al hacer clic se envían a los modal los parámetros necesarios) -->
                                                <a href="#" data-toggle="tooltip" title="Eliminar" data-bs-toggle="modal" data-bs-target="#eliminarModal" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['nombre'] ?>" class="link-dark open-delete tooltip-link"><i class="fas fa-trash fs-5 me-3"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } catch (PDOException $e) {
                                    // Si algo falla manda un mensaje con el error
                                    echo '<script>alert("¡Error al mostrar los datos! Contacte al administrador. " ' . $e->getMessage() . ');</script>';
                                    echo '<script>console.log("¡Error al mostrar los datos! Contacte al administrador. " ' . $e->getMessage() . ');</script>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal para Nuevo Registro -->
                    <div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-plus-square fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold" id="nuevoModalLabel">Nueva Editorial:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="nuevoRegistroForm">
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-style input-valid" title="Ingrese el nombre de la editorial." name="nombreC" id="nombreC" placeholder="Nombre de la Editorial">
                                        </div>
                                        <div class="justify-content-center text-center">
                                            <p id="errormsgC" class="d-none text-danger fw-bold">Revise los datos ingresados.</p>
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
                                    <h5 class="modal-title fw-bold">Editar Editorial:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editarRegistroForm">
                                        <div class="mb-3">
                                            <label class="fw-bold" for="nombreE">Nombre de la Editorial:</label>
                                            <input type="text" class="form-control input-style" title="Ingrese el nombre de la editorial." name="nombreE" id="nombreE" placeholder="Nombre de la Editorial">
                                        </div>
                                        <div class="justify-content-center text-center">
                                            <p id="errormsgE" class="d-none text-danger fw-bold errormsg">Revise los datos ingresados.</p>
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

                    <!-- Modal para Eliminar Registro -->
                    <div class="modal fade" id="eliminarModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class="fas fa-trash-alt fs-5 me-2"></i>
                                    <h5 class="modal-title fw-bold">Eliminar Editorial:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Realmente deseas eliminar la editorial <strong id="name-delete"></strong>?
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

            // Obtener mensajes de error, inputs y botón de guardar
            var nombreC = document.getElementById('nombreC');
            var nombreE = document.getElementById('nombreE');
            var btnGuardar = document.getElementById('submit');
            var btnEditar = document.getElementById('edit');
            var msgErrorC = document.getElementById('errormsgC');
            var msgErrorE = document.getElementById('errormsgE');

            // Validar inputs de modal guardar al realizar cambios en ellos
            nombreC.addEventListener('input', function() {
                // Validar que el input no esté vacío
                if (nombreC.value == '') {
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
                if (nombreE.value == '') {
                    // El input no es válido, mostrar un mensaje de error
                    msgErrorE.classList.remove("d-none");
                    btnEditar.setAttribute("disabled", "");
                } else {
                    // El input es válido
                    msgErrorE.classList.add("d-none");
                    btnEditar.removeAttribute("disabled"); // Activar botón para enviar datos
                }
            });

            // Nuevo Registro BD
            $("#submit").click(function() {
                // Obtener valores de los input
                var nombre = $("#nombreC").val();

                $.ajax({ // Petición AJAX
                    type: "POST", // Método POST
                    url: "create.php", // Archivo que contiene la consulta de inserción
                    data: { // Enviar datos
                        nombre: nombre
                    },
                    dataType: 'json',
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
                        } else { // Inserción fallida
                            $("#nuevoModal").modal("hide"); // Ocultar Modal
                            // Enviar alerta
                            $("#alertMessage").html("¡Error! No se pudo añadir el registro :(").addClass("alert-danger").fadeIn();
                            resetearInput();
                            setTimeout(function() {
                                $("#alertMessage").fadeOut();
                            }, 2000);
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
                    }
                });

            });

            // Editar Registro BD
            $('.open-edit').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var name = $(this).data('name');
                $("#nombreE").val(name);

                $('#edit').click(function() {
                    // Asignar valores 
                    var nombre = $("#nombreE").val();
                    $.ajax({ // Petición AJAX
                        type: "POST", // Método POST
                        url: "update.php", // Archivo que contiene la consulta de actualización
                        data: { // Enviar datos
                            id: id,
                            nombre: nombre
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

            // Eliminar Registro BD
            $('.open-delete').click(function() {
                // Obtener valores 
                var id = $(this).data('id');
                var nombre = $(this).data('name');
                $("#name-delete").html(nombre);

                // Confirmar eliminación
                $('#delete').click(function() {
                    $.ajax({ // Petición AJAX
                        type: "POST", // Método POST
                        url: "softdelete.php", // Archivo que contiene la consulta de eliminación
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

            // Función para resetear los valores de los input
            function resetearInput() {
                $("#nombreC").val('');
                $("#nombreE").val('');
            }
        });
    </script>
</body>

</html>