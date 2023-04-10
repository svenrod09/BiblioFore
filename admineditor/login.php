<?php
// Definir error
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión con la BD
    include './config.php';

    // Obtener los datos del formulario
    $usuario = $_POST['usuario']; // Usuario
    $password = $_POST['password']; // Contraseña

    // Trycatch para autenticarse en la BD
    try {
        // Consulta de selección PostgreSQL
        $query = "SELECT * FROM usuarios WHERE usuario = :usuario";

        // Preparar consulta
        $stmt = $db->prepare($query);

        // Definir parámetros
        $stmt->bindParam(':usuario', $usuario);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si el usuario existe en la base de datos
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC : Retorna en un array los datos devueltos por la consulta SQL
            // Verificar si la contraseña es correcta
            if (password_verify($password, $user['password'])) { // El usuario y contraseña existen en la BD
                // Iniciar sesión y redirigir a la página de inicio
                session_start();
                // Establecer las credenciales de la sesión
                $_SESSION['usuario'] = $user['usuario']; // Nombre de usuario
                $_SESSION['user_type'] = $user['tipousuarioid']; // Tipo de usuario 
                $_SESSION["logged_in"] = true; // Estado que indica que el usuario se ha logueado
                header('Location: ./adminPage.php'); // Redirecciona a la página de Inicio
            } else { // El usuario y contraseña NO existen en la BD
                // Mostrar un mensaje de error si la contraseña es incorrecta
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            // Mostrar un mensaje de error si el usuario no existe
            $error = "Usuario o contraseña incorrectos";
        }
    } catch (PDOException $e) {
        // Si algo falla manda un mensaje con el error
        echo '<script>alert("¡Error al intentar iniciar sesión! Contacte al administrador. "'
            . $e->getMessage() . ')</script>';
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

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="./css/loginStyles.css">

    <title>BiblioFore | Inicio de sesión</title>

    <!-- Ícono de la pestaña -->
    <link rel="shortcut icon" href="https://erp.unacifor.edu.hn/img/logout.png">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark theme-bg">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://unacifor.edu.hn/">
                <img src="https://erp.unacifor.edu.hn/img/logout.png" class="me-2" height="45" width="45" alt="UNACIFOR Logo" style="margin-left: 8%;" />
                <large class="fw-bold fs-4">UNACIFOR</large>
            </a>
        </div>
    </nav>

    <!-- Form para inicio de sesión -->
    <div class="container container-margin">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-1 shadow-lg overflow-hidden">
                    <div class="card-img-left d-none d-md-flex">
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-bold fs-2">Administración de Biblioteca</h5>
                        <form method="POST" action="login.php">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control input-style" name="usuario" id="usuario" placeholder="usuario" required autofocus>
                                <label for="usuario">Usuario</label>
                            </div>

                            <hr>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control input-style" name="password" id="password" placeholder="password" required autofocus>
                                <label for="password">Contraseña</label>
                                <i class="far fa-eye" id="show-password"></i>
                            </div>

                            <div class="error-content">
                                <p class="text-danger">
                                    <?php
                                    echo $error;
                                    ?>
                                </p>
                            </div>

                            <div class="d-grid mb-2">
                                <button class="btn btn-lg btn-login fw-bold text-uppercase" type="submit">Ingresar</button>
                            </div>

                            <a class="d-block text-center mt-2 medium" data-bs-toggle="modal" data-bs-target="#avisoModal" style="color: var(--primaryColor);">¿Olvidaste tus datos?</a>

                            <!-- Ventana Modal ¿Olvidaste tus datos? -->
                            <div class="modal fade" id="avisoModal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="cardm">
                                        <div class="text-right cross"> <i class="fa fa-times"></i> </div>
                                        <div class="card-body text-center"> <img class="modal-img" src="./resources/img/olvidar.png">
                                            <h4 class="fw-bold">¿OLVIDASTE TUS DATOS?</h4>
                                            <p>Parece que olvidaste tus datos. Contacta con el administrador de la aplicación.</p>
                                            <button type="button" class="btn btn-out btn-square continue text-uppercase">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        const showPasswordButton = document.getElementById('show-password'); // Obtiene el id del botón del ojo 
        const passwordInput = document.getElementById('password'); // Obtiene el id del input donde se ingresa la contraseña 

        // Al presionar el botón del ojo se revela la contraseña ingresada, al presionarlo de nuevo oculta la contraseña 
        showPasswordButton.addEventListener('click', function() { 
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordButton.classList.remove('fa-eye');
                showPasswordButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                showPasswordButton.classList.remove('fa-eye-slash');
                showPasswordButton.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>