<?php
// Trycatch para llenado de submenú de catálogo físico y digital
try {
    include '../config.php'; // Conexión con la BD

    // Inicio de una transacción
    $db->beginTransaction();

    // Consulta de selección PostgreSQL
    $query = "SELECT COUNT(*) FROM materialdigital;";

    // Preparar consulta
    $stmt1 = $db->prepare($query);

    // Ejecutar la consulta
    $stmt1->execute();

    // Verifica si la consulta devuelve datos
    if ($stmt1->rowCount() > 0) {
        while ($row = $stmt1->fetch()) {
            $conteo_md = $row['count']; // Conteo de entradas totales en catálogo digital
        }
    }

    // Consulta de selección PostgreSQL
    $query = "SELECT td.id, td.nombre, COUNT(td.id) FROM tipodocumento td INNER JOIN materialdigital md ON 
        td.id = md.tipodocumentoid GROUP BY td.id;";

    // Preparar consulta
    $stmt2 = $db->prepare($query);

    // Ejecutar la consulta
    $stmt2->execute();

    // Verifica si la consulta devuelve datos
    if ($stmt2->rowCount() > 0) {
        $cat_digital = $stmt2->fetchAll(PDO::FETCH_ASSOC); // Categorías existentes en el catálogo digital
    }

    // Finalización de la transacción
    $db->commit();

    // Cierre de las consultas
    $stmt1->closeCursor();
    $stmt2->closeCursor();

    // Cierre de la conexión
    $db = null;
} catch (PDOException $e) {
    echo "Error al mostrar categorías en el submenú: " . $e; // Mostrar mensaje de error
}
?>
<a class="dropdown-item" href="https://biblio.unacifor.edu.hn/usuario/catalogodigital/index.php">
    <span class="ms-2 fw-bold"><i class="fas fa-caret-right me-3"></i>Todos (<?php echo $conteo_md; ?>)</span>
</a>

<?php foreach ($cat_digital as $cat_digital) : ?>
    <a class="dropdown-item" href="https://biblio.unacifor.edu.hn/usuario/catalogodigital/categories/index.php?cat=<?= $cat_digital['id'] ?>&name=<?= $cat_digital['nombre'] ?>">
        <span class="ms-2 fw-bold"><i class="fas fa-caret-right me-3"></i><?= $cat_digital['nombre'] . ' (' . $cat_digital['count']; ?>)</span>
    </a>
<?php endforeach;
exit;
?>