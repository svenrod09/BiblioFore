<?php
// Datos para la conexión con la BD
define('DB_HOST', 'localhost'); // Nombre del host del servidor de la BD
define('DB_PORT', '5432'); // Puerto que utiliza el servidor de la BD
define('DB_NAME', 'bibliofore'); // Nombre de la BD
define('DB_USER', ''); // Nombre de usuario de la BD
define('DB_PASSWORD', ''); // Contraseña de la BD

// Trycatch para conectar con la BD
try {
    // Para interactuar con la BD se utiliza PDO (PHP Data Objects) para prevenir ataques de inyección SQL
    // $db: Variable que contiene el PDO que establece la conexión con la BD enviando los datos necesarios y
    // que fueron definidos anteriormente (pgsql: Indica que los datos envíados para la conexión son para una BD de PostgreSQL)
    $db = new PDO("pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    
    // Desactiva la emulación de instrucciones PDO
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Reporte de errores de PDO (reporta las excepciones de PDO)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Si algo falla manda un mensaje con el error
    echo '<script>console.log("¡Error al conectar con la BD! Causa: "' 
    . $e->getMessage() . ');</script>'; // Imprime el error en la consola
}
?>