<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/conection.php';

$title = "Usuarios del Proyecto";

$proyectoId = $_POST['id_proyecto'] ?? $_GET['id_proyecto'] ?? null;

if (!$proyectoId) {
    echo "<p>❌ Proyecto no especificado.</p>";
    exit;
}

$stmtProyecto = $conn->prepare("SELECT nombre FROM proyectos WHERE id = ?");
$stmtProyecto->bind_param("i", $proyectoId);
$stmtProyecto->execute();
$resultProyecto = $stmtProyecto->get_result();
$proyecto = $resultProyecto->fetch_assoc();

if (!$proyecto) {
    echo "<p>❌ Proyecto no encontrado.</p>";
    exit;
}

$sql = "SELECT u.id, u.nombre, u.email
        FROM usuarios u
        INNER JOIN usuario_proyecto up ON u.id = up.usuario_id
        WHERE up.proyecto_id = ? AND up.estado = 1";
$stmtUsuarios = $conn->prepare($sql);
$stmtUsuarios->bind_param("i", $proyectoId);
$stmtUsuarios->execute();
$resultUsuarios = $stmtUsuarios->get_result();

ob_start();
?>


<h1>Usuarios del proyecto: <?= htmlspecialchars($proyecto['nombre']) ?></h1>
<div class="text-center">
    <button class="btn-volver" onclick="window.location.href='/proyectosExforSAS/index.php'">⏪ Volver</button>
</div>
<?php if ($resultUsuarios->num_rows > 0): ?>
    <ul class="user-list">
        <?php while ($usuario = $resultUsuarios->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($usuario['nombre']) ?></strong><br>
                📧 <?= htmlspecialchars($usuario['email']) ?>
                <div class="user-actions">
                    <form class="form-eliminar-usuario" data-usuario-id="<?= $usuario['id'] ?>" data-proyecto-id="<?= $proyectoId ?>">
                        <button type="submit" class="btn btn-eliminar">Eliminar</button>
                    </form>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>Este proyecto aún no tiene usuarios asignados.</p>
<?php endif; ?>
<br>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
