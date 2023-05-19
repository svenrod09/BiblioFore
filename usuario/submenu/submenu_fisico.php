<?php
// Trycatch para llenado de submenú de catálogo físico y digital
try {
    include '../config.php'; // Conexión con la BD

    // Inicio de una transacción
    $db->beginTransaction();

    // Consulta de selección PostgreSQL
    $query = "SELECT COUNT(*) FROM materialfisico;";

    // Preparar consulta
    $stmt3 = $db->prepare($query);

    // Ejecutar la consulta
    $stmt3->execute();

    // Verifica si la consulta devuelve datos
    if ($stmt3->rowCount() > 0) {
        while ($row = $stmt3->fetch()) {
            $conteo_mf = $row['count']; // Conteo de entradas totales en catálogo físico
        }
    }

    // Consulta de selección PostgreSQL
    $query = "SELECT td.id, td.nombre, COUNT(td.id) FROM tipodocumento td INNER JOIN materialfisico mf ON 
        td.id = mf.tipodocumentoid GROUP BY td.id;";

    // Preparar consulta
    $stmt4 = $db->prepare($query);

    // Ejecutar la consulta
    $stmt4->execute();

    // Verifica si la consulta devuelve datos
    if ($stmt4->rowCount() > 0) {
        $cat_fisico = $stmt4->fetchAll(PDO::FETCH_ASSOC); // Categorías existentes en el catálogo físico
    }

    // Finalización de la transacción
    $db->commit();

    // Cierre de las consultas
    $stmt3->closeCursor();
    $stmt4->closeCursor();

    // Cierre de la conexión
    $db = null;
} catch (PDOException $e) {
    echo "Error al mostrar categorías en el submenú: " . $e; // Mostrar mensaje de error
}

?>

<a class="dropdown-item" href="https://biblio.unacifor.edu.hn/usuario/catalogofisico/index.php">
    <span class="ms-2 fw-bold"><i class="fas fa-caret-right me-3"></i>Todos (<?php echo $conteo_mf; ?>)</span>
</a>

<?php foreach ($cat_fisico as $cat_fisico) : ?>
    <a class="dropdown-item" href="https://biblio.unacifor.edu.hn/usuario/catalogofisico/categories/index.php?cat=<?= $cat_fisico['id']; ?>&name=<?= $cat_fisico['nombre'] ?>">
        <span class="ms-2 fw-bold"><i class="fas fa-caret-right me-3"></i><?= $cat_fisico['nombre'] . ' (' . $cat_fisico['count']; ?>)</span>
    </a>
<?php endforeach;
exit;
?>